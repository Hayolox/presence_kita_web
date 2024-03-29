<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\ProcessChangeQrCode;
use App\Models\check_que;
use App\Models\classroom;
use App\Models\classroomspratikum;
use App\Models\lecturer;
use App\Models\lecturer_subject;
use App\Models\presence;
use App\Models\room;
use App\Models\session;
use App\Models\setting;
use App\Models\student;
use App\Models\student_subject;
use App\Models\subject;
use App\Models\file;
use App\Models\presence_pratikum;
use App\Models\sessionpratikum;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\Writer\Pdf;

class PresenceController extends Controller
{
    public function index()
    {
        $lastSetting = setting::all()->last();
        $setting = setting::findOrfail($lastSetting->id);


        if (auth()->guard('web')->check()) {

            $subjects = subject::where('semester_id', $setting->semester_id)
                ->orWhere('semester_id', 3)
                ->paginate(10);
        }

        if (auth()->guard('lecturer')->check()) {

            $subjects = lecturer_subject::with(['classroom.subject' => function ($query) {
                $lastSetting = setting::all()->last();
                $setting = setting::findOrFail($lastSetting->id);
                $query->where('semester_id', $setting->semester_id)->orWhere('semester_id', 3);
            }])->where('lecturer_nip',  strval(Auth::user()->nip))->paginate(10);
        }

        $lastSetting = setting::all()->last();
        $setting = setting::findOrfail($lastSetting->id);


        return view('pages.admin.presence.index', compact('subjects', 'setting'));
    }

    public function classroom($subject_course_code)
    {
        if (auth()->guard('web')->check()) {
            $classrooms = classroom::where('subject_course_code', $subject_course_code)->paginate(10);
        } else {
            $classrooms = lecturer_subject::with(['classroom.subject' => function ($query) {
                $lastSetting = setting::all()->last();
                $setting = setting::findOrFail($lastSetting->id);
                $query->where('semester_id', $setting->semester_id);
            }])->where('lecturer_nip', strval(Auth::user()->nip))->paginate(10);
        }

        $subject = subject::where('course_code', $subject_course_code)->first();

        // dd($subject);



        return view('pages.admin.presence.classrooms', compact('classrooms', 'subject_course_code', 'subject'));
    }

    public function statistik($classrooms_id)
    {

        // $presence = DB::table('presences')
        //         ->select('student_nsn', DB::raw('COUNT(*) as total'))
        //         ->where('classrooms_id', $classrooms_id)
        //         ->where('status', 'izin')
        //         ->groupBy('student_nsn')
        //         ->orderByDesc('total')
        //         ->first();

        // $student = Student::where('nsn', $presence->student_nsn)->first();
        // if(!$student){
        //     $student = 'tidak ada';
        // }else{
        //     $student = $student->name;
        // }

        $students =  student_subject::where('classrooms_id', $classrooms_id)->get();

        $lastSetting = setting::all()->last();
        $setting = setting::findOrfail($lastSetting->id);
        $sessions = session::where('classrooms_id',  $classrooms_id)->where('semester_id', $setting->semester_id)->get();

        $nameStudentAlpha = [];
        foreach ($students as $item) {
            foreach ($sessions  as $session) {
                $presence = presence::where('session_id', $session->id)->where('student_nsn', $item->student_nsn)->first();
                if (!$presence) {
                    array_push($nameStudentAlpha, $item->student->name);
                }
            }
        }
        $countAlpha = count($nameStudentAlpha);
        $countIzin = presence::where('classrooms_id', $classrooms_id)->where('status', 'izin')->count();
        $countPresent =  presence::where('classrooms_id', $classrooms_id)->where('status', 'hadir')->count();
        $countStudentSubject =  $students =  student_subject::where('classrooms_id', $classrooms_id)->count();
        $data = [
            'countPresent' => $countPresent,
            'countIzin' => $countIzin,
            'countAlpha' => $countAlpha,
            'countAction' => $countStudentSubject * 16
        ];

        return view('pages.admin.presence.statistik', compact('data'));
    }


    public function session($classrooms_id)
    {
        $lastSetting = setting::all()->last();
        $setting = setting::findOrfail($lastSetting->id);
        $session = session::where('classrooms_id', $classrooms_id)
            ->where('semester_id', $setting->semester_id)
            ->where('year', $setting->year)->paginate(10);
        $countSession = session::where('classrooms_id', $classrooms_id)
            ->where('semester_id', $setting->semester_id)
            ->where('year', $setting->year)->count();

        $countIzin = presence::where('classrooms_id', $classrooms_id)->where('status', 'proses')->count();

        $classroom = classroom::where('id', $classrooms_id)->first();

        return view('pages.admin.presence.session', compact('session', 'classrooms_id', 'countIzin', 'countSession', 'classroom'));
    }

    public function pdf($classrooms_id)
    {

        $studentsList = student_subject::where('classrooms_id', $classrooms_id)->get();
        $session = session::where('classrooms_id', $classrooms_id)->get();

        $classroom = classroom::where('id', $classrooms_id)->first();
        $lecturer = lecturer_subject::where('classrooms_id', $classrooms_id)->get();
        $kelaspraktikum = classroomspratikum::where('subject_course_code', $classroom->subject_course_code)->get();


        foreach ($session as $key => $value) {
            $pertemuan['ke-' . $value->id] = 0;
        }

        if ($classroom->subject->is_pratikum) {

            for ($i = 0; $i < 5; $i++) {
                $pertemuan['ke-p' . $i + 1] = 0;
            }
        }




        foreach ($studentsList as $students) {
            $presence = presence::where([['classrooms_id', $classrooms_id], ['student_nsn', $students->student_nsn]])->get();

            if ($classroom->subject->is_pratikum) {

                $presencePraktikum = presence_pratikum::where([['student_nsn', $students->student_nsn]])->where(function ($query) use ($kelaspraktikum) {


                    foreach ($kelaspraktikum as $key => $value) {

                        if ($key == 0) {

                            $query->where('classroomspratikum_id', $value->id);
                        } else {

                            $query->orWhere('classroomspratikum_id', $value->id);
                        }
                    }
                })->get();

                foreach ($presencePraktikum as $i => $data) {
                    $sessionPraktikum = sessionpratikum::where('classroomspratikum_id', $data->classroomspratikum_id)->get();

                    foreach ($sessionPraktikum as $key => $value) {

                        if ($value->id == $data->session_pratikum_id) {
                            $students["pertemuanp" . $key + 1] = $data->status;
                            if ($data->status == 'hadir') {

                                $pertemuan['ke-p' . $key + 1]++;
                            }
                            break;
                        }
                    }
                }
            }


            foreach ($presence as $data) {
                $students["pertemuan" . $data->session_id] = $data->status;
                if ($data->status == 'hadir') {

                    $pertemuan['ke-' . $data->session_id]++;
                }
            }
        }


        return view('pages.admin.presence.pdf', compact('studentsList', 'classroom', 'lecturer', 'pertemuan', 'session'));
    }

    public function izin($classrooms_id)
    {

        $presence = presence::where('classrooms_id', $classrooms_id)->where('status', 'proses')->paginate();
        return view('pages.admin.presence.izin', compact('presence', 'classrooms_id'));
    }

    public function confirmIzin($sessionId, $useriId, $number)
    {
        $presence = presence::where('session_id', $sessionId)->where('student_nsn', $useriId)->first();
        $file = file::where('session_id', $sessionId)->where('student_nsn', $useriId)->first();
        $path = 'public/' . $file->path;

        if ($number == 1) {
            $filename = basename($path);
            return Storage::download($path, $filename, ['Content-Type' => 'application/pdf']);
        }

        if ($number == 2) {
            $presence->update([
                'status' => 'izin',
            ]);
            Storage::delete($path);
            $file->delete();

            Alert::success('Success', 'Surat Diterima');
        }

        if ($number == 3) {
            $presence->delete();
            Storage::delete($path);
            $file->delete();
            Alert::success('Success', 'Surat Ditolak');
        }

        return back();
    }

    public function createSession($classrooms_id)
    {
        $lecturers = lecturer_subject::where('classrooms_id', $classrooms_id)->get();
        $rooms = room::get();
        return view('pages.admin.presence.create', compact('lecturers', 'rooms', 'classrooms_id'));
    }


    public function storeSession(Request $request, $classrooms_id)
    {

        $classroom = classroom::where('id', $classrooms_id)->first();


        $request->validate([
            'title' => 'required',
            'start' => 'required',
            'finish' => 'required',
            'date' => 'required',
            'room_id' => 'required',
            'lecturer_nip' => 'required',
            'geolocation' => 'required',
        ]);

        $lastSetting = setting::all()->last();
        $setting = setting::findOrfail($lastSetting->id);
        $semester_id = $setting->semester_id;
        $year = $setting->year;


        if ($classroom->subject->is_pratikum == false) {
            $session = Session::where('classrooms_id', $classrooms_id)->latest()->first();
            $date = $session ? $session->date : $request->date;
            for ($i = 1; $i <= 16; $i++) {
                $qrCode = Str::random(20);
                if ($i > 1) {
                    $date = Carbon::parse($date)->addDays(7)->format('Y-m-d');
                }
                Session::create([
                    'QrCode' => $qrCode,
                    'title' => $request->title,
                    'start' => $request->start,
                    'finish' => $request->finish,
                    'date' => $date,
                    'lecturer_nip' => $request->lecturer_nip,
                    'semester_id' => $semester_id,
                    'classrooms_id' => $classrooms_id,
                    'year' => $year,
                    'room_id' => $request->room_id,
                    'geolocation' => $request->geolocation,
                ]);
            }
        } else {
            $session = Session::where('classrooms_id', $classrooms_id)->latest()->first();
            $date = $session ? $session->date : $request->date;
            for ($i = 1; $i <= 11; $i++) {
                $qrCode = Str::random(20);
                if ($i > 1) {
                    $date = Carbon::parse($date)->addDays(7)->format('Y-m-d');
                }
                Session::create([
                    'QrCode' => $qrCode,
                    'title' => $request->title,
                    'start' => $request->start,
                    'finish' => $request->finish,
                    'date' => $date,
                    'lecturer_nip' => $request->lecturer_nip,
                    'semester_id' => $semester_id,
                    'classrooms_id' => $classrooms_id,
                    'year' => $year,
                    'room_id' => $request->room_id,
                    'geolocation' => $request->geolocation,
                ]);
            }
        }



        Alert::success('Success', 'Data Berhasil Ditambahkan');
        return redirect()->route('ManagePresence.session', ['classrooms_id' => $classrooms_id]);
    }

    public function editSession($id, $classrooms_id)
    {

        $session = session::findOrFail($id);
        $rooms = room::get();
        $lecturers = lecturer_subject::where('classrooms_id', $classrooms_id)->get();
        return view('pages.admin.presence.edit', compact('session', 'rooms', 'lecturers', 'classrooms_id'));
    }

    public function updateSession($id, $classrooms_id, Request $request)
    {

        $session = session::findOrFail($id);
        $request->validate([
            'title' => 'required',
            'start' => 'required',
            'finish' => 'required',
            'date' => 'required',
            'room_id' => 'required',
            'lecturer_nip' => 'required',
            'geolocation' => 'required',
        ]);

        $session->update([
            'title' => $request->title,
            'start' => $request->start,
            'finish' => $request->finish,
            'date' => $request->date,
            'lecturer_nip' => $request->lecturer_nip,
            'room_id' => $request->room_id,
            'geolocation' => $request->geolocation,
        ]);
        Alert::success('Success', 'Data Berhasil Ditambahkan');
        return redirect()->route('ManagePresence.session', ['classrooms_id' => $classrooms_id]);
    }


    public function presence($id, $classrooms_id)
    {
        $session_id = $id;
        $students = presence::where('session_id', $session_id)->paginate();
        return view('pages.admin.presence.presence', compact('students', 'classrooms_id', 'session_id'));
    }

    public function addStudentToPresence($session_id, $classrooms_id)
    {


        return view('pages.admin.presence.add_student_to_session', compact('session_id', 'classrooms_id'));
    }

    public function storeAddStudentToPresence($session_id, $classrooms_id, Request $request)
    {
        $checkStudent = student::where('nsn', $request->nim)->first();

        if (!$checkStudent) {

            Alert::warning('Student Tidak Terdaftar', 'Maaf Akun Student Tidak Di Temukan');
            return back();
        }

        $checkStudent = student_subject::where('classrooms_id', $classrooms_id)->where('student_nsn', $request->nim)->first();

        if (!$checkStudent) {
            Alert::warning('Student Tidak Terdaftar', 'Maaf Student Tidak Terdaftar Pada Mata Kuliah');
            return back();
        }

        $checkStudent = presence::where('session_id', $session_id)
            ->where('classrooms_id', $classrooms_id)
            ->where('student_nsn', $request->nim)->first();

        if ($checkStudent) {
            Alert::warning('Student Sudah Melakukan Presensi', 'Maaf Student Sudah Melakukan Presensi');
            return back();
        }

        presence::create([
            'session_id' => $session_id,
            'classrooms_id' => $classrooms_id,
            'student_nsn' => $request->nim,
            'status' => 'hadir'
        ]);

        Alert::success('Succes', 'Student Berhasil Ditambahkan Ke Presensi');
        return back();
    }


    public function qRCode($id, $qrCode)
    {
        // dd("test");

        $countQue = check_que::where('QrCode', $qrCode)->count();

        $lastSetting = setting::all()->last();
        $setting = setting::findOrfail($lastSetting->id);

        if ($countQue == 0) {
            check_que::create([
                'QrCode' => $qrCode
            ]);
            $job = new ProcessChangeQrCode($id, $qrCode, 'kuliah');

            $queue = Queue::getFacadeRoot();
            $count = $queue->size();

            if ($count > 1) {
                ProcessChangeQrCode::dispatch($id, $qrCode, 'kuliah')->delay(now()->addMinutes(1));
            } elseif ($count > 2) {
                ProcessChangeQrCode::dispatch($id, $qrCode, 'kuliah');
            } else {

                ProcessChangeQrCode::dispatch($id, $qrCode, 'kuliah')->delay(now()->addMinutes($setting->count_down_qrcode));
            }
        }
        $session = session::where('id', $id)->where('QrCode', $qrCode)->firstOrFail();


        $dataArray = array(
            'qrCode' => $session->QrCode,
            'sessionId' => $session->id,
            'classrooms_id' => $session->classrooms_id,
            'geolocation' => $session->geolocation,
            'latitude' => $session->room->latitude,
            'longitude' =>  $session->room->longitude,
        );
        $dataString = json_encode($dataArray);
        $id = $session->id;
        $code = "'" . $session->QrCode . "'";
        return view('pages.admin.presence.QrCode', compact('dataString', 'id', 'code'));
    }

    public function getqRCode($id)
    {


        $session = session::where('id', $id)->firstOrFail();


        $dataArray = array(
            'qrCode' => $session->QrCode,

        );
        $dataString = json_encode($dataArray);
        return $dataString;
    }
}

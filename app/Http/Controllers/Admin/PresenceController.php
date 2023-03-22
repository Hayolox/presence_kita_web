<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\ProcessChangeQrCode;
use App\Models\check_que;
use App\Models\classroom;
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
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\Writer\Pdf;

class PresenceController extends Controller
{
    public function index(){
        $lastSetting = setting::all()->last();
        $setting = setting::findOrfail($lastSetting->id);


        if(auth()->guard('web')->check()){

            $subjects = subject::where('semester_id',$setting->semester_id)
            ->orWhere('semester_id', 3)
            ->paginate(10);
        }

        if(auth()->guard('lecturer')->check()){
             $subjects = lecturer_subject::with(['classroom.subject' => function ($query) {
                    $lastSetting = setting::all()->last();
                    $setting = setting::findOrFail($lastSetting->id);
                    $query->where('semester_id', $setting->semester_id);
             }])->where('lecturer_nip', Auth::user()->nip)->paginate(10);
        }


        return view('pages.admin.presence.index', compact('subjects'));
    }

    public function classroom($subject_course_code){
        if(auth()->guard('web')->check()){
            $classrooms = classroom::where('subject_course_code', $subject_course_code)->paginate(10);
        }else{
        $classrooms = lecturer_subject::with(['classroom.subject' => function ($query) {
                $lastSetting = setting::all()->last();
                $setting = setting::findOrFail($lastSetting->id);
                $query->where('semester_id', $setting->semester_id);
         }])->where('lecturer_nip', Auth::user()->nip)->paginate(10);
        }



        return view('pages.admin.presence.classrooms', compact('classrooms', 'subject_course_code'));
      }


    public function session($classrooms_id){
        $lastSetting = setting::all()->last();
        $setting = setting::findOrfail($lastSetting->id);
        $session = session::where('classrooms_id', $classrooms_id)
                    ->where('semester_id', $setting->semester_id)
                    ->where('year', $setting->year)->paginate(10);
        $countSession = session::where('classrooms_id', $classrooms_id)
                    ->where('semester_id', $setting->semester_id)
                    ->where('year', $setting->year)->count();

        $countIzin = presence::where('classrooms_id', $classrooms_id)->where('status', 'proses')->count();


        return view('pages.admin.presence.session', compact('session','classrooms_id', 'countIzin','countSession'));
    }

    public function izin($classrooms_id){

        $presence = presence::where('classrooms_id', $classrooms_id)->where('status', 'proses')->paginate();
       return view('pages.admin.presence.izin', compact('presence','classrooms_id'));
    }

    public function confirmIzin($sessionId, $useriId, $number){
        $presence = presence::where('session_id', $sessionId)->where('student_nsn', $useriId)->first();
        $file = file::where('session_id', $sessionId)->where('student_nsn', $useriId)->first();
        $path = 'public/' . $file->path;

       if($number == 1){
        $filename = basename($path);
        return Storage::download($path, $filename, ['Content-Type' => 'application/pdf']);

       }

       if($number == 2){
        $presence->update([
            'status' => 'izin',
        ]);
        Storage::delete($path);
        $file->delete();

        Alert::success('Success', 'Surat Diterima');
       }

       if($number == 3){
            $presence->delete();
            Storage::delete($path);
            $file->delete();
            Alert::success('Success', 'Surat Ditolak');
       }

       return back();

    }

    public function createSession($classrooms_id){
        $lecturers = lecturer_subject::where('classrooms_id',$classrooms_id)->get();
        $rooms = room::get();
        return view('pages.admin.presence.create', compact('lecturers','rooms','classrooms_id'));
    }


    public function storeSession(Request $request, $classrooms_id){

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


        if($classroom->subject->is_pratikum == false){
            $session = Session::where('classrooms_id', $classrooms_id)->latest()->first();
            $date = $session ? $session->date : $request->date;
            for( $i = 1; $i <= 16; $i++){
                $qrCode = Str::random(20);
                if($i > 1){
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
        }else{
            $session = Session::where('classrooms_id', $classrooms_id)->latest()->first();
            $date = $session ? $session->date : $request->date;
            for( $i = 1; $i <= 11; $i++){
                $qrCode = Str::random(20);
                if($i > 1){
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

    public function editSession($id,$classrooms_id){

        $session = session::findOrFail($id);
        $rooms = room::get();
        $lecturers = lecturer_subject::where('classrooms_id',$classrooms_id)->get();
       return view('pages.admin.presence.edit', compact('session','rooms', 'lecturers','classrooms_id'));
    }

    public function updateSession($id,$classrooms_id, Request $request){

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


    public function presence($id, $classrooms_id){
        $session_id = $id;
        $students = presence::where('session_id', $session_id)->paginate();
        return view('pages.admin.presence.presence', compact('students', 'classrooms_id', 'session_id'));
    }

    public function addStudentToPresence($session_id, $classrooms_id){


        return view('pages.admin.presence.add_student_to_session', compact('session_id', 'classrooms_id'));
    }

    public function storeAddStudentToPresence($session_id, $classrooms_id, Request $request){
        $checkStudent = student::where('nsn', $request->nim)->first();

        if(!$checkStudent){

            Alert::warning('Student Tidak Terdaftar', 'Maaf Akun Student Tidak Di Temukan');
            return back();
        }

        $checkStudent = student_subject::where('classrooms_id', $classrooms_id)->where('student_nsn', $request->nim)->first();

        if(!$checkStudent){
            Alert::warning('Student Tidak Terdaftar', 'Maaf Student Tidak Terdaftar Pada Mata Kuliah');
            return back();
        }

        $checkStudent = presence::where('session_id', $session_id)
                                  ->where('classrooms_id', $classrooms_id)
                                  ->where('student_nsn', $request->nim)->first();

        if($checkStudent){
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


    public function qRCode($id, $qrCode){

        $countQue = check_que::where('QrCode', $qrCode)->count();

        $lastSetting = setting::all()->last();
        $setting = setting::findOrfail($lastSetting->id);

        if($countQue == 0){
            check_que::create([
                'QrCode' => $qrCode
            ]);
            $job = new ProcessChangeQrCode($id, $qrCode);


            $queue = Queue::getFacadeRoot();
            $count = $queue->size();

            if($count > 1){
                ProcessChangeQrCode::dispatch($id, $qrCode )->delay(now()->addMinutes(1));
            }elseif($count > 2){
                 ProcessChangeQrCode::dispatch($id, $qrCode );
            }
            else{

                ProcessChangeQrCode::dispatch($id, $qrCode )->delay(now()->addMinutes($setting->count_down_qrcode));
            }
        }
        $session = session::where('id', $id)->where('QrCode',$qrCode )->firstOrFail();


        $dataArray = array(
            'qrCode' => $session->QrCode,
            'sessionId' => $session->id,
            'classrooms_id' => $session->classrooms_id,
            'geolocation' => $session->geolocation,
            'latitude' => $session->room->latitude,
            'longitude' =>  $session->room->longitude,
        );
        $dataString = json_encode($dataArray);
        return view('pages.admin.presence.QrCode', compact('dataString'));
    }
}

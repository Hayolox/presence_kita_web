<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Imports\StudentPratikumImport;
use App\Jobs\ProcessChangeQrCode;
use App\Models\asistantpratikum;
use App\Models\check_que;
use App\Models\classroom;
use App\Models\classroomspratikum;
use App\Models\file_pratikum;
use App\Models\lecturer_subject;
use App\Models\presence_pratikum;
use App\Models\room;
use App\Models\sessionpratikum;
use App\Models\setting;
use App\Models\student;
use App\Models\student_pratikum;
use App\Models\subject;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Storage;

class PresencePratikumController extends Controller
{
    public function index(){
        $lastSetting = setting::all()->last();
        $setting = setting::findOrfail($lastSetting->id);

        if(auth()->guard('web')->check()){

            $subjects = subject::where('semester_id',$setting->semester_id)->where('is_pratikum', true)
            ->orWhere('semester_id', 3)
            ->paginate(10);
        }

        if(auth()->guard('student')->check()){
            $subjects = asistantpratikum::with(['classroompratikum.subject' => function ($query) {
                    $lastSetting = setting::all()->last();
                    $setting = setting::findOrFail($lastSetting->id);
                    $query->where('semester_id', $setting->semester_id);
            }])->where('student_nsn', Auth::user()->nsn)->paginate(10);
        }

        return view('pages.admin.presence_pratikum.index', compact('subjects'));
    }

    public function classroom($subject_course_code){
        $classrooms = classroomspratikum::where('subject_course_code', $subject_course_code)->paginate(10);

        if(auth()->guard('web')->check()){
            $classrooms = classroomspratikum::where('subject_course_code', $subject_course_code)->paginate(10);
        }else{
        $classrooms = asistantpratikum::with(['classroompratikum.subject' => function ($query) {
                $lastSetting = setting::all()->last();
                $setting = setting::findOrFail($lastSetting->id);
                $query->where('semester_id', $setting->semester_id);
        }])->where('student_nsn', Auth::user()->nsn)->paginate(10);
        }
        return view('pages.admin.presence_pratikum.classrooms', compact('classrooms','subject_course_code'));
    }

    public function createClassroom($subject_course_code){
        return view('pages.admin.presence_pratikum.create_classroom', compact('subject_course_code'));
    }

    public function storeClassromm($subject_course_code, Request $request){

        $request->validate([
            'name' => 'required',
        ]);



        classroomspratikum::create([
            'name' => $request->name,
            'subject_course_code' => $subject_course_code
        ]);
        Alert::success('Success', 'Data Berhasil Ditambahkan');
        return back();
    }

    public function addAsistenPratikum($classroomsPratikumId, Request $request){

        if(!$request->nim){
            Alert::info('Info', 'Harus Input Nim');
            return back();
        }

        $student = student::where('nsn', $request->nim)->first();

        if(!$student){
            Alert::info('Info', 'Student Tidak Ditemukan');
            return back();
        }

        asistantpratikum::create([
            'student_nsn' => $request->nim,
            'classroomspratikum_id' => $classroomsPratikumId
        ]);
        Alert::success('Success', 'Data Berhasil Ditambahkan');
        return back();
    }

    public function editAsistenPratikum($classroomsPratikumId, Request $request){

        if(!$request->nim){
            Alert::info('Info', 'Harus Input Nim');
            return back();
        }

        $student = student::where('nsn', $request->nim)->first();

        if(!$student){
            Alert::info('Info', 'Student Tidak Ditemukan');
            return back();
        }

        $asisten = asistantpratikum::where('classroomspratikum_id', $classroomsPratikumId)->first();

        $asisten->update([
            'student_nsn' => $request->nim,
            'classroomspratikum_id' => $classroomsPratikumId
        ]);
        Alert::success('Success', 'Data Berhasil Di Edit');
        return back();
    }

    public function dataStudent(Request $request, $classroomsPratikumId){

        $duplicates = student_pratikum::select('student_nsn', 'classroomspratikum_id')
                ->selectRaw('COUNT(*) as count')
                ->groupBy('student_nsn', 'classroomspratikum_id')
                ->having('count', '>', 1)
                ->get();

                foreach ($duplicates as $duplicate) {
                    student_pratikum::where('student_nsn', $duplicate->student_nsn)
                        ->where('classroomspratikum_id', $duplicate->classroomspratikum_id)
                        ->whereNotIn('id', function($query) use ($duplicate) {
                            $query->selectRaw('MIN(id)')
                                ->from('student_pratikums')
                                ->where('student_nsn', $duplicate->student_nsn)
                                ->where('classroomspratikum_id', $duplicate->classroomspratikum_id);
                })->delete();
            }

        $lastSetting = setting::all()->last();
        $setting = setting::findOrfail($lastSetting->id);

        $students = student_pratikum::where('classroomspratikum_id', $classroomsPratikumId)->where('year',  $setting->year)->paginate(10);

        if($request->has('search'))
        {
            $students = student_pratikum::where('student_nsn', 'LIKE', '%' .$request->search. '%')->where('classroomspratikum_id', $classroomsPratikumId)->paginate(10);
        }



        return view('pages.admin.presence_pratikum.dataStudent', compact('students','classroomsPratikumId'));
    }

    public function dataStudentCreate($classroomsPratikumId){

        return view('pages.admin.presence_pratikum.dataStudentCreate', compact('classroomsPratikumId'));
    }

    public function dataStudentStore($classroomsPratikumId, Request $request){

        $request->validate([
            'nsn' => 'required'
        ]);

        $lastSetting = setting::all()->last();
        $setting = setting::findOrfail($lastSetting->id);

        $student = student::where('nsn', $request->nsn)->first();

        if(!$student){
            Alert::info('Info', 'Data Student Tidak Ditemukan');
            return back();
        }

        student_pratikum::create([
            'student_nsn' =>$request->nsn,
            'classroomspratikum_id' => $classroomsPratikumId,
            'year' => $setting->year
        ]);

        Alert::success('Success', 'Data Berhasil Ditambahkan');
        return back();
    }

    public function import(Request $request, $classroomsPratikumId)
    {

        $lastSetting = setting::all()->last();
        $setting = setting::findOrfail($lastSetting->id);
        $file =  $request->file('file');
        $classroomsPratikumId = intval($classroomsPratikumId);
        (new StudentPratikumImport($classroomsPratikumId, $setting->year))->import($file);
        return back();
    }

    public function session($classroomsPratikumId){
        $lastSetting = setting::all()->last();
        $setting = setting::findOrfail($lastSetting->id);
        $session = sessionpratikum::where('classroomspratikum_id', $classroomsPratikumId)
                    ->where('semester_id', $setting->semester_id)
                    ->where('year', $setting->year)->paginate(10);
        $countSession = sessionpratikum::where('classroomspratikum_id', $classroomsPratikumId)
                    ->where('semester_id', $setting->semester_id)
                    ->where('year', $setting->year)->count();

        $countIzin = presence_pratikum::where('classroomspratikum_id', $classroomsPratikumId)->where('status', 'proses')->count();


        return view('pages.admin.presence_pratikum.session', compact('session','classroomsPratikumId', 'countIzin','countSession'));
    }

    public function izin($classroomsPratikumId){

       $presence = presence_pratikum::where('classroomspratikum_id', $classroomsPratikumId)->where('status', 'proses')->paginate();
       return view('pages.admin.presence_pratikum.izin', compact('presence','classroomsPratikumId'));
    }

    public function confirmIzin($sessionId, $useriId, $number){

        $presence = presence_pratikum::where('session_pratikum_id', $sessionId)->where('student_nsn', $useriId)->first();
        $file = file_pratikum::where('session_pratikum_id', $sessionId)->where('student_nsn', $useriId)->first();
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

    public function createSession($classroomsPratikumId){
        $rooms = room::get();
        return view('pages.admin.presence_pratikum.create', compact('rooms','classroomsPratikumId'));
    }

    public function storeSession(Request $request, $classroomsPratikumId){

        $request->validate([
            'title' => 'required',
            'start' => 'required',
            'finish' => 'required',
            'date' => 'required',
            'room_id' => 'required',
            'geolocation' => 'required',
        ]);

        $lastSetting = setting::all()->last();
        $setting = setting::findOrfail($lastSetting->id);
        $semester_id = $setting->semester_id;
        $year = $setting->year;
        $qrCode = Str::random(20);

        $asisten = asistantpratikum::where('classroomspratikum_id',$classroomsPratikumId)->first();

        $session = sessionpratikum::where('classroomspratikum_id', $classroomsPratikumId)->latest()->first();
            $date = $session ? $session->date : $request->date;
            for( $i = 1; $i <= 5; $i++){
                if($i > 1){
                    $date = Carbon::parse($date)->addDays(7)->format('Y-m-d');
                }
                sessionpratikum::create([
                    'QrCode' => $qrCode,
                    'title' => $request->title,
                    'start' => $request->start,
                    'finish' => $request->finish,
                    'date' => $date,
                    'student_nsn' =>  $asisten->student_nsn,
                    'semester_id' => $semester_id,
                    'classroomspratikum_id' => $classroomsPratikumId,
                    'year' => $year,
                    'room_id' => $request->room_id,
                    'geolocation' => $request->geolocation,
                ]);
            }



        Alert::success('Success', 'Data Berhasil Ditambahkan');
        return redirect()->route('ManagePresence.classrooms.pratikum.session', ['classrooms_pratikum_id' => $classroomsPratikumId]);
    }

    public function editSession($id,$classroomsPratikumId){

        $session = sessionpratikum::findOrFail($id);
        $rooms = room::get();
       return view('pages.admin.presence_pratikum.edit', compact('session','rooms','classroomsPratikumId'));
    }

    public function updateSession($id,$classroomsPratikumId, Request $request){

        $session = sessionpratikum::findOrFail($id);
        $request->validate([
            'title' => 'required',
            'start' => 'required',
            'finish' => 'required',
            'date' => 'required',
            'room_id' => 'required',
            'geolocation' => 'required',
        ]);

        $asisten = asistantpratikum::where('classroomspratikum_id', $classroomsPratikumId)->first();
        $session->update([
            'title' => $request->title,
            'start' => $request->start,
            'finish' => $request->finish,
            'date' => $request->date,
            'student_nsn' => $asisten->student_nsn,
            'room_id' => $request->room_id,
            'geolocation' => $request->geolocation,
        ]);
        Alert::success('Success', 'Data Berhasil Ditambahkan');
        return redirect()->route('ManagePresence.classrooms.pratikum.session', ['classrooms_pratikum_id' => $classroomsPratikumId]);
    }

    public function presence($id, $classroomsPratikumId){

        $students = presence_pratikum::where('session_pratikum_id', $id)->paginate(10);
        return view('pages.admin.presence_pratikum.presence', compact('students', 'classroomsPratikumId', 'id'));
    }

    public function addStudentToPresence($session_id, $classroomsPratikumId){
        return view('pages.admin.presence_pratikum.add_student_to_session', compact('session_id', 'classroomsPratikumId'));
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
        $session = sessionpratikum::where('id', $id)->where('QrCode',$qrCode )->firstOrFail();


        $dataArray = array(
            'qrCode' => $session->QrCode,
            'session_pratikum_id' => $session->id,
            'classroomspratikum_id' => $session->classroomspratikum_id,
            'geolocation' => $session->geolocation,
            'latitude' => $session->room->latitude,
            'longitude' =>  $session->room->longitude,
        );
        $dataString = json_encode($dataArray);
        return view('pages.admin.presence.QrCode', compact('dataString'));
    }

    public function storeAddStudentToPresence($session_id, $classroomspratikum_id, Request $request){

        $checkStudent = student::where('nsn', $request->nim)->first();

        if(!$checkStudent){

            Alert::warning('Student Tidak Terdaftar', 'Maaf Akun Student Tidak Di Temukan');
            return back();
        }

        $checkStudent = student_pratikum::where('classroomspratikum_id', $classroomspratikum_id)->where('student_nsn', $request->nim)->first();

        if(!$checkStudent){
            Alert::warning('Student Tidak Terdaftar', 'Maaf Student Tidak Terdaftar Pada Pratikum');
            return back();
        }

        $checkStudent = presence_pratikum::where('session_pratikum_id', $session_id)
                                  ->where('classroomspratikum_id', $classroomspratikum_id)
                                  ->where('student_nsn', $request->nim)->first();

        if($checkStudent){
            Alert::warning('Student Sudah Melakukan Presensi', 'Maaf Student Sudah Melakukan Presensi');
            return back();
        }

        presence_pratikum::create([
            'session_pratikum_id' => $session_id,
            'classroomspratikum_id' => $classroomspratikum_id,
            'student_nsn' => $request->nim,
            'status' => 'hadir'
        ]);

        Alert::success('Succes', 'Student Berhasil Ditambahkan Ke Presensi');
        return back();
    }
}

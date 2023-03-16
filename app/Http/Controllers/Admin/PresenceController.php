<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\ProcessChangeQrCode;
use App\Models\check_que;
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
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Queue;

class PresenceController extends Controller
{
    public function index(){
        $lastSetting = setting::all()->last();
        $setting = setting::findOrfail($lastSetting->id);
        $subjects = subject::where('semester_id',$setting->semester_id)
                            ->orWhere('semester_id', 3)
                            ->paginate(10);
        return view('pages.admin.presence.index', compact('subjects'));
    }


    public function session($course_code){
        $lastSetting = setting::all()->last();
        $setting = setting::findOrfail($lastSetting->id);
        $session = session::where('subject_course_code', $course_code)
                    ->where('semester_id', $setting->semester_id)
                    ->where('year', $setting->year)->paginate();

        $countIzin = presence::where('subject_course_code', $course_code)->where('status', 'proses')->count();


        return view('pages.admin.presence.session', compact('session','course_code', 'countIzin'));
    }

    public function izin($course_code){

        $presence = presence::where('subject_course_code', $course_code)->where('status', 'proses')->paginate();
       return view('pages.admin.presence.izin', compact('presence'));
    }

    public function createSession($course_code){
        $lecturers = lecturer_subject::where('subject_course_code',$course_code)->get();
        $rooms = room::get();
        return view('pages.admin.presence.create', compact('lecturers','rooms','course_code'));
    }


    public function storeSession(Request $request, $course_code){
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
        $qrCode = Str::random(20);
        session::create([
            'QrCode' => $qrCode,
            'title' => $request->title,
            'start' => $request->start,
            'finish' => $request->finish,
            'date' => $request->date,
            'lecturer_nip' => $request->lecturer_nip,
            'semester_id' => $semester_id,
            'subject_course_code' => $course_code,
            'year' => $year,
            'room_id' => $request->room_id,
            'geolocation' => $request->geolocation,

        ]);

        Alert::success('Success', 'Data Berhasil Ditambahkan');
        return redirect()->route('ManagePresence.session', ['id' => $course_code]);
    }

    public function editSession($id,$course_code){

        $session = session::findOrFail($id);
        $rooms = room::get();
        $lecturers = lecturer_subject::where('subject_course_code',$course_code)->get();
       return view('pages.admin.presence.edit', compact('session','rooms', 'lecturers','course_code'));
    }

    public function updateSession($id,$course_code, Request $request){

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
        return redirect()->route('ManagePresence.session', ['id' => $course_code]);
    }


    public function presence($id, $course_code){
        $session_id = $id;
        $students = presence::where('session_id', $session_id)->paginate();
        return view('pages.admin.presence.presence', compact('students', 'course_code', 'session_id'));
    }

    public function addStudentToPresence($session_id, $course_code){


        return view('pages.admin.presence.add_student_to_session', compact('session_id', 'course_code'));
    }

    public function storeAddStudentToPresence($session_id, $course_code, Request $request){
        $checkStudent = student::where('nsn', $request->nim)->first();

        if(!$checkStudent){

            Alert::warning('Student Tidak Terdaftar', 'Maaf Akun Student Tidak Di Temukan');
            return back();
        }

        $checkStudent = student_subject::where('subject_course_code', $course_code)->where('student_nsn', $request->nim)->first();

        if(!$checkStudent){
            Alert::warning('Student Tidak Terdaftar', 'Maaf Student Tidak Terdaftar Pada Mata Kuliah');
            return back();
        }

        $checkStudent = presence::where('session_id', $session_id)
                                  ->where('subject_course_code', $course_code)
                                  ->where('student_nsn', $request->nim)->first();

        if($checkStudent){
            Alert::warning('Student Sudah Melakukan Presensi', 'Maaf Student Sudah Melakukan Presensi');
            return back();
        }

        presence::create([
            'session_id' => $session_id,
            'subject_course_code' => $course_code,
            'student_nsn' => $request->nim,
            'status' => 'hadir'
        ]);

        Alert::success('Succes', 'Student Berhasil Ditambahkan Ke Presensi');
        return back();
    }


    public function qRCode($id, $qrCode){

        $countQue = check_que::where('QrCode', $qrCode)->count();

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
                ProcessChangeQrCode::dispatch($id, $qrCode )->delay(now()->addMinutes(2));
            }
        }
        $session = session::where('id', $id)->where('QrCode',$qrCode )->firstOrFail();
        return view('pages.admin.presence.QrCode', compact('session'));
    }
}

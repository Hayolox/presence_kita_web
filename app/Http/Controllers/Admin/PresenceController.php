<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\ProcessChangeQrCode;
use App\Models\lecturer;
use App\Models\lecturer_subject;
use App\Models\presence;
use App\Models\room;
use App\Models\session;
use App\Models\setting;
use App\Models\subject;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Queue;

class PresenceController extends Controller
{
    public function index(){
        $lastSetting = setting::all()->last();
        $setting = setting::findOrfail($lastSetting->id);
        $subjects = subject::where('semester_id',$setting->semester_id)->orWhere('semester_id', 3)->paginate(10);
        return view('pages.admin.presence.index', compact('subjects'));
    }


    public function session($course_code){
        $lastSetting = setting::all()->last();
        $setting = setting::findOrfail($lastSetting->id);
        $session = session::where('subject_course_code', $course_code)
                    ->where('semester_id', $setting->semester_id)
                    ->where('year', $setting->year)->paginate();


        return view('pages.admin.presence.session', compact('session','course_code'));
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


    public function presence($id){

        $students = presence::where('session_id', $id)->paginate();
        return view('pages.admin.presence.presence', compact('students'));
    }


    public function qRCode($id, $qrCode){

        ProcessChangeQrCode::dispatch($id)->delay(now()->addMinutes(1));
        $session = session::where('id', $id)->where('QrCode',$qrCode )->firstOrFail();
        return view('pages.admin.presence.QrCode', compact('session'));
    }
}

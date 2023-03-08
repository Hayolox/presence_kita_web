<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\presence;
use App\Models\session;
use App\Models\setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class SessionApiController extends Controller
{
    public function index(Request $request){


        $session = session::where('subject_course_code', $request->subject_course_code)->get();
        $presence = presence::where('subject_course_code', $request->subject_course_code)->where('status', 'hadir')->count();
        $permission  = presence::where('subject_course_code', $request->subject_course_code)->where('status', 'izin')->count();
        $status_session = [];

        foreach ($session as $item) {

            $checkPresences = presence::where('session_id', $item->id)
                                    ->where("subject_course_code",$request->subject_course_code)
                                    ->where('student_nsn', Auth::user()->nsn)->first();

            if($checkPresences){

                array_push($status_session, $checkPresences->status);

            }else{
                array_push($status_session, 'none');
            }

        }
        if (isset(array_count_values($status_session)['none'])) {
            $count_none = array_count_values($status_session)['none'];

        } else {
            $count_none = 0;
        }
        return ResponseFormatter::success(
            [
                'presence' => $presence,
                'permission' => $permission,
                'alpha' => $count_none,
                'status_session' => $status_session,
                'sessions' => $session,
            ],
            'Berhasil Ambil Data'
        );
    }



    public function store(Request $request){
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
            'subject_course_code' => $request->subject_course_code,
            'year' => $year,
            'room_id' => $request->room_id,
            'geolocation' => $request->geolocation,
        ]);

        return ResponseFormatter::success(
            [
               "message" => "Berhasil Tambah Session"
            ],
            'Berhasil Tambah Session'
        );
    }


}

<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\presence;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PresenceApiController extends Controller
{
    public function present(Request $request){
        presence::create([
            'session_id' => $request->session_id,
            'subject_course_code' => $request->subject_course_code,
            'student_nsn' => Auth::user()->nsn,
            'status' => $request->status,
        ]);

        return ResponseFormatter::success(
            [
               "message" => "Berhasil Melakukan Presensi"
            ],
            'Berhasil Melakukan Presensi'
        );
    }
}

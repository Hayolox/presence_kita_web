<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\file;
use App\Models\presence;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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

    public function izin(Request $request){

     $file = $request->file('izin');
     $path = $file->storeAs('pdf/sakit', uniqid().'.'.$file->extension(), ['disk'=> 'public']);
    //  Storage::url($path)

    file::create([
        'session_id' => $request->session_id,
        'student_nsn' => Auth::user()->nsn,
        'path' => $path,
        'status' => 0,
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now()
    ]);

     return ResponseFormatter::success(
        [
           "message" =>  "Berhasil upload data"
        ],
        'Berhasil upload data'
    );
    }
}

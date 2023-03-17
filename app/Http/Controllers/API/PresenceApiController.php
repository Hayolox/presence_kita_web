<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\file;
use App\Models\presence;
use App\Models\session;
use App\Models\setting;
use App\Models\sus_student;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PresenceApiController extends Controller
{
    public function present(Request $request){
        $lastSetting = setting::all()->last();
        $setting = setting::findOrfail($lastSetting->id);

        $checkSUS = $setting->SUS;

        if($checkSUS == 1){
                $checkStudent = sus_student::where('student_nsn', Auth::user()->nsn)->first();
                    if(!$checkStudent){
                        return ResponseFormatter::error(
                            [
                               "message" => "Belum Mengisi Kusioner"
                            ],
                            'Belum Mengisi Kusioner'
                        );
                    }

        }

        $checkDonePresent = presence::where('session_id',$request->session_id)->where('student_nsn', Auth::user()->nsn)->first();
        if($checkDonePresent){
            return ResponseFormatter::error(
                [
                   "message" => "Anda Sudah Hadir"
                ],
                'Anda Sudah Hadir', 403
            );
        }
        $checkQrCode = session::find($request->session_id);

        if($checkQrCode->QrCode != $request->QrCode){
            return ResponseFormatter::error(
                [
                   "message" => "QrCode Tidak Sama"
                ],
                'QrCode Tidak Sama'
            );
        }
        presence::create([
            'session_id' => $request->session_id,
            'classrooms_id' => $request->classrooms_id,
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

    presence::create([
        'session_id' => $request->session_id,
        'classrooms_id' => $request->classrooms_id,
        'student_nsn' => Auth::user()->nsn,
        'status' => 'proses',
    ]);

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

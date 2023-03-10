<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\API\ResponseFormatter as APIResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\check_login;
use App\Models\student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class   AuthContorller extends Controller
{
    public function login(Request $request){


      try{

        if(!Auth::guard('student')->attempt($request->only('nsn', 'password'))){
            return ResponseFormatter::error(
                ["message" => "Unauthorized"],
                'Authentication Failed',
                 500

            );
        }
        $student = student::with('major')-> where('nsn', $request->nsn)->first();


        if (! $student || ! Hash::check($request->password, $student->password)) {
            throw new \Exception('Invalid Credential');
        }

        $tokenResult = $student->createToken('mobile')->plainTextToken;

        $check_login = check_login::where('student_nsn', $student->nsn)->count();

        if($student->android_id == null){
            $student->update([
                'android_id' => $request->android_id,
            ]);
        }else{
            if($student->android_id != $request->android_id || $check_login > 2){
                return ResponseFormatter::error(
                    ["message" => "Terdeteksi Curang"],
                    'Terdeteksi Curang',
                     404

                );
            }
        }



        check_login::create([
            'student_nsn' => $student->nsn
        ]);

        return ResponseFormatter::success(
            [
                'access_token' => $tokenResult,
                'student' => $student,
            ],
            'Login Berhasil'
        );

      }catch(\Throwable $th ){
        return response()->json([
            'message' => $th,

        ]);
      }
    }

    public function logout(){
        Auth::logout();
        return ResponseFormatter::success(
            [
                "message" => "Logout Berhasil"
            ],
            'Logout Berhasil'
        );
    }


    public function changePassword(Request $request){

        if(Hash::check($request->old_password, auth()->user()->password)){

            $student =   student::where('nsn', Auth::user()->nsn)->firstOrFail();

            $student->update([
                'password' => Hash::make($request->new_password)
            ]);

            return ResponseFormatter::success(
                [
                    "message" => "Ganti Password Berhasil"
                ],
                'Ganti Password Berhasil'
            );


        }else{
            return ResponseFormatter::error(
                [
                    "message" => "Ganti Password Gagal"
                ],
                'Ganti Password Gagal'
            );
        }
    }
}

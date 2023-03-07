<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\API\ResponseFormatter as APIResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthContorller extends Controller
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
}

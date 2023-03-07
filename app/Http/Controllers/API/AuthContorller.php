<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthContorller extends Controller
{
    public function login(Request $request){


        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);
        if(Auth::guard('student')->attempt($request->only('nsn', 'password'))){
            return redirect()->route('Dashboard');
        }else{
            return redirect('/')->with('toast_error', 'Email Atau Password Salah');
        }
    }
}

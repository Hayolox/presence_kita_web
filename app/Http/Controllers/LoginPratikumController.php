<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginPratikumController extends Controller
{
    public function index(){
        return view('pages.login_pratikum');
    }

    public function login(Request $request){

        $request->validate([
            'nsn' => 'required',
            'password' => 'required'
        ]);



        if(Auth::guard('student')->attempt($request->only('nsn', 'password'))){
            return redirect()->route('ManagePresencePratikum');
        }else{
            return redirect('lecturer')->with('toast_error', 'Email Atau Password Salah');
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }


}

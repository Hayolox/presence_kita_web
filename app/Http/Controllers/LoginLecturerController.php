<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginLecturerController extends Controller
{
    public function index(){
        return view('pages.login_lecturer');
    }

    public function login(Request $request){

        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);



        if(Auth::guard('lecturer')->attempt($request->only('username', 'password'))){
            return redirect()->route('ManagePresence');
        }else{
            return redirect('lecturer')->with('toast_error', 'Email Atau Password Salah');
        }
    }


}

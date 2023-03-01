<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Crypt;

class ChangePasswordController extends Controller
{
    public function index(){
            return view('pages.admin.change_password.index');
    }

    public function update(Request $request){


        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required',
        ]);



        if(Hash::check($request->old_password, auth()->user()->password)){

            User::whereId(auth()->user()->id)->update([
                'password' => Hash::make($request->new_password)
            ]);

            Alert::success('Succes', 'Password Berhasil Diubah');
            return back();

        }else{
            Alert::warning('Gagal', 'Password Lama Salah');
            return back();
        }







    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\lecturer;
use Illuminate\Http\Request;

class ManageLecturerDataController extends Controller
{
    public function index(){
        $lecturers = lecturer::paginate(10);
        return view('pages.admin.manage_lecturer.index', compact('lecturers'));
    }


    public function delete($id){
        $lecturer = lecturer::where('nip', $id)->first();
        $lecturer->delete();
        return back();
    }
}

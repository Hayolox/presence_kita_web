<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\lecturer;
use App\Models\student;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
        $countStudent = student::count();
        $countLecturer = lecturer::count();
        return view('pages.admin.dashboard', compact('countStudent', 'countLecturer'));
    }
}

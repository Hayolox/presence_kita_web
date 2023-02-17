<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\subject;
use Illuminate\Http\Request;

class ManageSubjectController extends Controller
{
    public function index(){
        $subjects = subject::paginate(10);
        return view('pages.admin.manage_subject.index', compact('subjects'));
    }
}

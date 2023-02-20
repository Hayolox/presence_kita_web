<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\major;
use App\Models\semester;
use App\Models\subject;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class ManageSubjectsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $subjects = subject::paginate(10);

        if($request->has('search'))
        {
            $subjects = subject::where('full_name', 'LIKE', '%' .$request->search. '%')->paginate(10);
        }
        return view('pages.admin.manage_subject.index', compact('subjects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $majors = major::get();
        $semesters = semester::get();
        return view('pages.admin.manage_subject.create', compact('majors','semesters'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'course_code' => 'required|unique:subjects,course_code',
            'full_name' => 'required',
            'nickname' => 'required',
            'major_id' => 'required|numeric',
            'semester_id' => 'required|numeric',
       ],[
          'major_id.numeric' => 'The majors field is required.',
          'semester_id.numeric' => 'The semesters field is required.',
       ]);


       subject::create([
        'course_code' => $request->course_code,
        'full_name' => $request->full_name,
        'nickname' => $request->nickname,
        'major_id' => $request->major_id,
        'semester_id' => $request->semester_id,
       ]);
       Alert::success('Success', 'Data Berhasil Ditambahkan');
       return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $majors = major::get();
        $semesters = semester::get();
        $subject = subject::findOrFail($id);
        return view('pages.admin.manage_subject.edit', compact('majors','semesters','subject'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $subject = subject::findOrFail($id);
        $request->validate([
            'course_code' => 'required',
            'full_name' => 'required',
            'nickname' => 'required',
            'major_id' => 'required|numeric',
            'semester_id' => 'required|numeric',
       ],[
          'major_id.numeric' => 'The majors field is required.',
          'semester_id.numeric' => 'The semesters field is required.',
       ]);

       $subject->update([
        'course_code' => $request->course_code,
        'full_name' => $request->full_name,
        'nickname' => $request->nickname,
        'major_id' => $request->major_id,
        'semester_id' => $request->semester_id,
       ]);
       Alert::success('Success', 'Data Berhasil Diedit');
       return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $student = subject::where('course_code', $id)->first();
        $student->delete();
        Alert::success('Success', 'Data Berhasil Dihapus');
        return back();
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Imports\StudentsImport;
use App\Models\major;
use App\Models\student;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use RealRashid\SweetAlert\Facades\Alert;

class ManageStudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $students = student::paginate(10);

        if($request->has('search'))
        {
            $students = student::where('name', 'LIKE', '%' .$request->search. '%')->paginate(10);
        }
        return view('pages.admin.manage_student.index', compact('students'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $majors = major::get();
        return view('pages.admin.manage_student.create', compact('majors'));
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
            'nsn' => 'required|unique:students,nsn',
            'name' => 'required',
            'generation' => 'required|numeric',
            'major_id' => 'required',
       ]);

       dd($request->nsn);

       student::create([
        'nsn' => $request->nsn,
        'name' => $request->name,
        'generation' => $request->generation,
        'password' =>bcrypt($request->nsn),
        'major_id' => $request->major_id,
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
        $student = student::findOrfail($id);
        $majors = major::get();
        return view('pages.admin.manage_student.edit', compact(['student','majors']));
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
        $student = student::findOrFail($id);

        $request->validate([
            'nsn' => 'required',
            'name' => 'required',
            'generation' => 'required|numeric',
            'major_id' => 'required',
       ]);




        if($request->password){
            $aatr = bcrypt($request->password);
        }else{
            $aatr = $student->password;

        }

        $student->update([
            'nsn' => $request->nsn,
            'name' => $request->name,
            'generation' => $request->generation,
            'password' =>bcrypt($aatr),
            'major_id' => $request->major_id,
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
        $student = student::where('nsn', $id)->first();
        $student->delete();
        Alert::success('Success', 'Data Berhasil Dihapus');
        return back();
    }

    public function import(Request $request)
    {
        $file =  $request->file('file');
        (new StudentsImport)->import($file);
        return back();
    }
}

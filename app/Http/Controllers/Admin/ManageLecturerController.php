<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\lecturer;
use App\Models\major;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;


class ManageLecturerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lecturers = lecturer::paginate(10);
        return view('pages.admin.manage_lecturer.index', compact('lecturers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $majors = major::get();
        return view('pages.admin.manage_lecturer.create', compact('majors'));
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
            'nip' => 'required',
            'full_name' => 'required',
            'username' => 'required',
            'major_id' => 'required',
       ]);

       lecturer::create([
        'nip' => $request->nip,
        'full_name' => $request->full_name,
        'username' => $request->username,
        'password' =>bcrypt($request->username.'123'),
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $lecturer = lecturer::where('nip', $id)->first();
        $lecturer->delete();
        Alert::success('Success', 'Data Berhasil Dihapus');
        return back();
    }
}

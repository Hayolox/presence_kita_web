<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\semester;
use App\Models\setting;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class ManageSystemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $count = setting::count();
        $last = setting::all()->last();
        $semesters = semester::get();
        if ($count > 0){
            $setting = setting::findOrfail($last->id);
            return view('pages.admin.manage_system.index', compact('count','setting','semesters'));
        }else{
            return view('pages.admin.manage_system.index', compact('count','semesters'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'year_id' => 'numeric',
            'semester_id' => 'numeric',
            'sus' => 'required',
        ],[
            'year_id.numeric' => 'The year field is required.',
            'semester_id.numeric' => 'The semester field is required.',
            'sus.numeric' => 'The sus field is required.',
        ]);

        setting::create(
         [
            'semester_id' => $request->semester_id,
            'year' => $request->year,
            'sus' => $request->sus,
         ]
        );

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

        $request->validate([
            'year_id' => 'numeric',
            'semester_id' => 'numeric',
            'sus' => 'required',
            'count_down_qrcode' => 'required'
        ],[
            'year_id.numeric' => 'The year field is required.',
            'semester_id.numeric' => 'The semester field is required.',
            'sus.numeric' => 'The sus field is required.',
        ]);
        $system = setting::findOrFail($id);

        $system->update([
            'semester_id' => $request->semester_id,
            'year' => $request->year,
            'sus' => $request->sus,
            'count_down_qrcode' => $request->count_down_qrcode
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
        //
    }
}

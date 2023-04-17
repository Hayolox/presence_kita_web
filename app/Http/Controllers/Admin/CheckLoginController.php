<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\cheating_history;
use App\Models\check_login;
use App\Models\history_kecurangan;
use App\Models\setting;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\student;
use App\Models\student_subject;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckLoginController extends Controller
{
    public function index(Request $request)
    {

        // $duplicateRecords = DB::table('check_logins')
        //     ->selectRaw('student_nsn , COUNT(*) as count')
        //     ->groupBy('student_nsn')
        //     ->havingRaw('COUNT(*) > 1')
        //     ->get();

        $duplicateRecords = check_login::selectRaw('student_nsn , COUNT(*) as count')
            ->groupBy('student_nsn')
            ->havingRaw('COUNT(*) > 1')
            ->get();

        // dd($duplicateRecords[0]->student->name);
        if ($request->has('search')) {
            $duplicateRecords = DB::table('check_logins')
                ->selectRaw('student_nsn , COUNT(*) as count')
                ->groupBy('student_nsn')
                ->havingRaw('COUNT(*) > 1')
                ->where('student_nsn', 'LIKE', '%' . $request->search . '%')
                ->get();
        }


        return view('pages.admin.check_login.index', compact('duplicateRecords'));
    }
    public function history(Request $request)
    {

        if($request->has('search'))
        {
            $data = cheating_history::where('student_nsn', 'LIKE', '%' . $request->search . '%')->get();
        }else{
            $data = cheating_history::get();
        }
        return view('pages.admin.check_login.history', compact('data'));
    }




    public function destroy($id)
    {

        $lastSetting = setting::all()->last();
        $setting = setting::findOrfail($lastSetting->id);

        $data = check_login::where('student_nsn', $id)->first();
        cheating_history::create(
            [
                "student_nsn" => $data->student_nsn,
                "year" => $setting->year,
                "semester_id" => $setting->semester_id,
            ]
        );

        check_login::where('student_nsn', $id)->delete();
        Alert::success('Success', 'Data Berhasil Dihapus');
        return back();
    }
}

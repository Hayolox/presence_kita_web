<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\check_login;
use App\Models\history_kecurangan;
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
    public function history()
    {

        // $duplicateRecords = DB::table('check_logins')
        //     ->selectRaw('student_nsn , COUNT(*) as count')
        //     ->groupBy('student_nsn')
        //     ->havingRaw('COUNT(*) > 1')
        //     ->get();

        $data = history_kecurangan::all();

        // dd($data);




        return view('pages.admin.check_login.history', compact('data'));
    }




    public function destroy($id)
    {
        $bulan = intval(date('m'));
        if ($bulan <= 1 || $bulan >= 8) $semester = 1;
        else $semester = 2;

        $data = check_login::where('student_nsn', $id)->first();
        history_kecurangan::create(
            [
                "student_nsn" => $data->student_nsn,
                "tahun" => date('Y'),
                "semester_id" => $semester,
            ]
        );
        // dd('test');
        check_login::where('student_nsn', $id)->delete();
        Alert::success('Success', 'Data Berhasil Dihapus');
        return back();
    }
}

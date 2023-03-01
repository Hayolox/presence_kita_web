<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\check_login;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\student;
use App\Models\student_subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckLoginController extends Controller
{
    public function index(Request $request){

        $duplicateRecords = DB::table('check_logins')
                    ->selectRaw('student_nsn , COUNT(*) as count')
                    ->groupBy('student_nsn')
                    ->havingRaw('COUNT(*) > 1')
                    ->get();

            if($request->has('search'))
            {
                $duplicateRecords = DB::table('check_logins')
                ->selectRaw('student_nsn , COUNT(*) as count')
                ->groupBy('student_nsn')
                ->havingRaw('COUNT(*) > 1')
                ->where('student_nsn', 'LIKE', '%' .$request->search. '%')
                ->get();
            }

        return view('pages.admin.check_login.index', compact('duplicateRecords'));
    }

    public function destroy($id){

        check_login::where('student_nsn', $id)->delete();
        Alert::success('Success', 'Data Berhasil Dihapus');
        return back();
    }
}

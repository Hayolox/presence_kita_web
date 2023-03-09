<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\sus;
use App\Models\sus_student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SUSController extends Controller
{
    public function getQuestion(){
        $sus = sus::all()->last();
        $sus = sus::findOrfail($sus->id);
        $questionSUS = $sus;
        return ResponseFormatter::success(
            $questionSUS,
            'Berhasil Ambil Data'
        );
    }

    public function postAnswer(Request $request){
        sus_student::create([
            'student_nsn' => Auth::user()->nsn,
            'Q1' => $request->Q1,
            'Q2' => $request->Q2,
            'Q3' => $request->Q3,
            'Q4' => $request->Q4,
            'Q5' => $request->Q5,
            'Q6' => $request->Q6,
            'Q7' => $request->Q7,
            'Q8' => $request->Q8,
            'Q9' => $request->Q9,
            'Q10' => $request->Q10,
            'amount' => $request->amount
        ]);

        return ResponseFormatter::success(
            [
               "message" => "Berhasil Mengisi Kusioner"
            ],
            'Berhasil Mengisi Kusioner'
        );
    }
}

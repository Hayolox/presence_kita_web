<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\setting;
use App\Models\student_subject;
use App\Models\sus_student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeApiController extends Controller
{
    public function index(Request $request){



        $studentSubject = student_subject::with('subject')->where('student_nsn', Auth::user()->nsn);
        $studentSubject = $studentSubject->whereHas('subject', function( $query ) use ( $request ){
                            $lastSetting = setting::all()->last();
                            $setting = setting::findOrfail($lastSetting->id);
                                $query->where('semester_id', $setting->semester_id);
                            });

        $lastSetting = setting::all()->last();
        $setting = setting::findOrfail($lastSetting->id);

        $checkSUS = $setting->SUS;

        if($checkSUS == 1){
                $checkStudent = sus_student::where('student_nsn', Auth::user()->nsn)->first();
                    if($checkStudent){
                        $checkSUS = 0;
                    }else{
                        $checkSUS = 1;
                    }
        }

        if($checkSUS == 0){
            $checkSUS = 0;
        }


        $studentSubject = $studentSubject->get();

        $countStudentInSubject = [];

        foreach ($studentSubject as $item) {
         $countStudent =     student_subject::where('subject_course_code', $item->subject_course_code)->count();
         array_push($countStudentInSubject, $countStudent);
        }

        return ResponseFormatter::success(
            [
                'SUS' => $checkSUS,
                'countStudentInSubject' => $countStudentInSubject,
                'subject' => $studentSubject,

            ],
            'Berhasil Ambil Data'
        );
    }
}

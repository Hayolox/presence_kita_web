<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\setting;
use App\Models\student_subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeApiController extends Controller
{
    public function index(Request $request){



        $studentSubject = student_subject::with('subject')->where('student_nsn', Auth::user()->nsn);
        $studentSubject = $studentSubject->whereHas('subject', function( $query ) use ( $request ){
                            $lastSetting = setting::all()->last();
                            $setting = setting::findOrfail($lastSetting->id);
                                $query->where('semester_id',     $setting->semester_id);
                            });


        $studentSubject = $studentSubject->get();

        $countStudentInSubject = [];

        foreach ($studentSubject as $item) {
         $countStudent =     student_subject::where('subject_course_code', $item->subject_course_code)->count();
         array_push($countStudentInSubject, $countStudent);
        }

        return ResponseFormatter::success(
            [
                'countStudentInSubject' => $countStudentInSubject,
                'subject' => $studentSubject,

            ],
            'Berhasil Ambil Data'
        );
    }
}

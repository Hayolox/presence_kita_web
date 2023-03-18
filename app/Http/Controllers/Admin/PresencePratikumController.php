<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Imports\StudentPratikumImport;
use App\Models\asistantpratikum;
use App\Models\classroom;
use App\Models\classroomspratikum;
use App\Models\setting;
use App\Models\student;
use App\Models\student_pratikum;
use App\Models\subject;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class PresencePratikumController extends Controller
{
    public function index(){
        $lastSetting = setting::all()->last();
        $setting = setting::findOrfail($lastSetting->id);
        $subjects = subject::where('semester_id',$setting->semester_id)->where('is_pratikum', true)
                            ->orWhere('semester_id', 3)
                            ->paginate(10);

        return view('pages.admin.presence_pratikum.index', compact('subjects'));
    }

    public function classroom($subject_course_code){
        $classrooms = classroomspratikum::where('subject_course_code', $subject_course_code)->paginate(10);
        return view('pages.admin.presence_pratikum.classrooms', compact('classrooms','subject_course_code'));
    }

    public function createClassroom($subject_course_code){
        return view('pages.admin.presence_pratikum.create_classroom', compact('subject_course_code'));
    }

    public function storeClassromm($subject_course_code, Request $request){

        $request->validate([
            'name' => 'required',
        ]);



        classroomspratikum::create([
            'name' => $request->name,
            'subject_course_code' => $subject_course_code
        ]);
        Alert::success('Success', 'Data Berhasil Ditambahkan');
        return back();
    }

    public function addAsistenPratikum($classroomsPratikumId, Request $request){

        if(!$request->nim){
            Alert::info('Info', 'Harus Input Nim');
            return back();
        }

        $student = student::where('nsn', $request->nim)->first();

        if(!$student){
            Alert::info('Info', 'Student Tidak Ditemukan');
            return back();
        }

        asistantpratikum::create([
            'student_nsn' => $request->nim,
            'classroomspratikum_id' => $classroomsPratikumId
        ]);
        Alert::success('Success', 'Data Berhasil Ditambahkan');
        return back();
    }

    public function editAsistenPratikum($classroomsPratikumId, Request $request){

        if(!$request->nim){
            Alert::info('Info', 'Harus Input Nim');
            return back();
        }

        $student = student::where('nsn', $request->nim)->first();

        if(!$student){
            Alert::info('Info', 'Student Tidak Ditemukan');
            return back();
        }

        $asisten = asistantpratikum::where('classroomspratikum_id', $classroomsPratikumId)->first();

        $asisten->update([
            'student_nsn' => $request->nim,
            'classroomspratikum_id' => $classroomsPratikumId
        ]);
        Alert::success('Success', 'Data Berhasil Di Edit');
        return back();
    }

    public function dataStudent(Request $request, $classroomsPratikumId){

        $duplicates = student_pratikum::select('student_nsn', 'classroomspratikum_id')
                ->selectRaw('COUNT(*) as count')
                ->groupBy('student_nsn', 'classroomspratikum_id')
                ->having('count', '>', 1)
                ->get();

                foreach ($duplicates as $duplicate) {
                    student_pratikum::where('student_nsn', $duplicate->student_nsn)
                        ->where('classroomspratikum_id', $duplicate->classroomspratikum_id)
                        ->whereNotIn('id', function($query) use ($duplicate) {
                            $query->selectRaw('MIN(id)')
                                ->from('student_pratikums')
                                ->where('student_nsn', $duplicate->student_nsn)
                                ->where('classroomspratikum_id', $duplicate->classroomspratikum_id);
                })->delete();
            }

        $lastSetting = setting::all()->last();
        $setting = setting::findOrfail($lastSetting->id);

        $students = student_pratikum::where('classroomspratikum_id', $classroomsPratikumId)->where('year',  $setting->year)->paginate(10);

        if($request->has('search'))
        {
            $students = student_pratikum::where('student_nsn', 'LIKE', '%' .$request->search. '%')->where('classroomspratikum_id', $classroomsPratikumId)->paginate(10);
        }



        return view('pages.admin.presence_pratikum.dataStudent', compact('students','classroomsPratikumId'));
    }

    public function dataStudentCreate($classroomsPratikumId){

        return view('pages.admin.presence_pratikum.dataStudentCreate', compact('classroomsPratikumId'));
    }

    public function dataStudentStore($classroomsPratikumId, Request $request){

        $request->validate([
            'nsn' => 'required'
        ]);

        $lastSetting = setting::all()->last();
        $setting = setting::findOrfail($lastSetting->id);

        $student = student::where('nsn', $request->nsn)->first();

        if(!$student){
            Alert::info('Info', 'Data Student Tidak Ditemukan');
            return back();
        }

        student_pratikum::create([
            'student_nsn' =>$request->nsn,
            'classroomspratikum_id' => $classroomsPratikumId,
            'year' => $setting->year
        ]);

        Alert::success('Success', 'Data Berhasil Ditambahkan');
        return back();
    }

    public function import(Request $request, $classroomsPratikumId)
    {

        $lastSetting = setting::all()->last();
        $setting = setting::findOrfail($lastSetting->id);
        $file =  $request->file('file');
        (new StudentPratikumImport($classroomsPratikumId, $setting->year))->import($file);
        return back();
    }
}

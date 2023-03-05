<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Imports\StudentSubjectImport;
use App\Models\lecturer;
use App\Models\lecturer_subject;
use App\Models\major;
use App\Models\semester;
use App\Models\student;
use App\Models\student_subject;
use App\Models\subject;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use RealRashid\SweetAlert\Facades\Alert;

class ManageSubjectsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $subjects = subject::paginate(10);

        if($request->has('search'))
        {
            $subjects = subject::where('full_name', 'LIKE', '%' .$request->search. '%')->paginate(10);
        }
        return view('pages.admin.manage_subject.index', compact('subjects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $majors = major::get();
        $semesters = semester::get();
        return view('pages.admin.manage_subject.create', compact('majors','semesters'));
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
            'course_code' => 'required|unique:subjects,course_code',
            'full_name' => 'required',
            'nickname' => 'required',
            'major_id' => 'required|numeric',
            'semester_id' => 'required|numeric',
       ],[
          'major_id.numeric' => 'The majors field is required.',
          'semester_id.numeric' => 'The semesters field is required.',
       ]);


       subject::create([
        'course_code' => $request->course_code,
        'full_name' => $request->full_name,
        'nickname' => $request->nickname,
        'major_id' => $request->major_id,
        'semester_id' => $request->semester_id,
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
        $majors = major::get();
        $semesters = semester::get();
        $subject = subject::findOrFail($id);
        return view('pages.admin.manage_subject.edit', compact('majors','semesters','subject'));
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
        $subject = subject::findOrFail($id);
        $request->validate([
            'course_code' => 'required',
            'full_name' => 'required',
            'nickname' => 'required',
            'major_id' => 'required|numeric',
            'semester_id' => 'required|numeric',
       ],[
          'major_id.numeric' => 'The majors field is required.',
          'semester_id.numeric' => 'The semesters field is required.',
       ]);

       $subject->update([
        'course_code' => $request->course_code,
        'full_name' => $request->full_name,
        'nickname' => $request->nickname,
        'major_id' => $request->major_id,
        'semester_id' => $request->semester_id,
       ]);
       Alert::success('Success', 'Data Berhasil Diedit');
       return redirect()->route('ManageSubject.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $student = subject::where('course_code', $id)->first();
        $student->delete();
        Alert::success('Success', 'Data Berhasil Dihapus');
        return back();
    }

    public function dataLecturer($id){
        $course_id = $id;

        $duplicates = lecturer_subject::select('lecturer_nip', 'subject_course_code')
        ->selectRaw('COUNT(*) as count')
        ->groupBy('lecturer_nip', 'subject_course_code')
        ->having('count', '>', 1)
        ->get();

        foreach ($duplicates as $duplicate) {
            lecturer_subject::where('lecturer_nip', $duplicate->lecturer_nip)
                ->where('subject_course_code', $duplicate->subject_course_code)
                ->whereNotIn('id', function($query) use ($duplicate) {
                    $query->selectRaw('MIN(id)')
                        ->from('lecturer_subjects')
                        ->where('lecturer_nip', $duplicate->lecturer_nip)
                        ->where('subject_course_code', $duplicate->subject_course_code);
        })->delete();
    }
        $lecturers = lecturer_subject::where('subject_course_code', $id)->paginate(10);
        $lecturerss = lecturer::get();
        return view('pages.admin.manage_subject.dataLecturer', compact('lecturers','course_id','lecturerss'));
    }

    public function dataLecturerStore(Request $request, $course_id){

        if($request->lecturer_nip == 0){
            Alert::warning('Warning ', 'Harus Memilih Dosen');
        }else{
            lecturer_subject::create([
                'lecturer_nip' => $request->lecturer_nip,
                'subject_course_code' => $course_id,
            ]);
        }
         return back();
    }


    public function dataLecturerDestroy($id){
        $lecturers = lecturer_subject::findOrFail($id);
        $lecturers->delete();
        Alert::success('Success', 'Data Berhasil Dihapus');
        return back();
    }

    public function dataStudent(Request $request, $id){
        $course_id = $id;



        $duplicates = student_subject::select('student_nsn', 'subject_course_code')
                ->selectRaw('COUNT(*) as count')
                ->groupBy('student_nsn', 'subject_course_code')
                ->having('count', '>', 1)
                ->get();

                foreach ($duplicates as $duplicate) {
                    student_subject::where('student_nsn', $duplicate->student_nsn)
                        ->where('subject_course_code', $duplicate->subject_course_code)
                        ->whereNotIn('id', function($query) use ($duplicate) {
                            $query->selectRaw('MIN(id)')
                                ->from('student_subjects')
                                ->where('student_nsn', $duplicate->student_nsn)
                                ->where('subject_course_code', $duplicate->subject_course_code);
                })->delete();
            }


        $students = student_subject::where('subject_course_code', $id)->paginate(10);

        if($request->has('search'))
        {
            $students = student_subject::where('student_nsn', 'LIKE', '%' .$request->search. '%')->where('subject_course_code', $course_id)->paginate(10);
        }
        $studentss = student::get();
        return view('pages.admin.manage_subject.dataStudent', compact('students','course_id','studentss'));
    }

    public function dataStudentCreate($subject_course_code){

        return view('pages.admin.manage_subject.dataStudentCreate', compact('subject_course_code'));
    }

    public function dataStudentStore($subject_course_code, Request $request){
        $request->validate([
            'student_nsn' => 'required'
        ]);

        student_subject::create([
            'student_nsn' =>$request->student_nsn,
            'subject_course_code' => $subject_course_code,
        ]);

        Alert::success('Success', 'Data Berhasil Ditambahkan');
        return back();
    }

    public function import(Request $request, $subject_course_code)
    {
        $file =  $request->file('file');
        (new StudentSubjectImport($subject_course_code))->import($file);
        return back();
    }

    public function downloadTemplate(){
        $templatePath = public_path('template/template_import_student_to_subject.xlsx');
        return response()->download($templatePath, 'template_untuk_import_mahasisswa_ke_matakuliah.xlsx');
    }

    public function dataStudentDestroy($id){
        $lecturers = student_subject::findOrFail($id);
        $lecturers->delete();
        Alert::success('Success', 'Data Berhasil Dihapus');
        return back();
    }


}

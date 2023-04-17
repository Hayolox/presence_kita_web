<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Imports\StudentSubjectImport;
use App\Models\classroom;
use App\Models\lecturer;
use App\Models\lecturer_subject;
use App\Models\major;
use App\Models\semester;
use App\Models\setting;
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
        $lastSetting = setting::all()->last();
        $setting = setting::findOrfail($lastSetting->id);
        $subjects = subject::where('semester_id', $setting->semester_id)
            ->orWhere('semester_id', 3)
            ->paginate(10);

        if ($request->has('search')) {
            $subjects = subject::where('full_name', 'LIKE', '%' . $request->search . '%')->paginate(10);
        }

        foreach ($subjects as $index => $value) {
            $jumlah = student_subject::join('classrooms', 'classrooms.id', '=', 'student_subjects.classrooms_id')->where('subject_course_code', $value->course_code)->count();
            $subjects[$index]->jumlah = $jumlah;
        }

        // dd($subjects);
        $lastSetting = setting::all()->last();
        $setting = setting::findOrfail($lastSetting->id);

        // dd($setting);

        return view('pages.admin.manage_subject.index', compact('subjects', 'setting'));
    }


    public function classroom($subject_course_code)
    {
        $classrooms = classroom::where('subject_course_code', $subject_course_code)->paginate(10);
        $subject = subject::where('course_code', $subject_course_code)->first();
        // dd($test);
        return view('pages.admin.manage_subject.classrooms', compact('classrooms', 'subject_course_code', 'subject'));
    }

    public function createClassroom($subject_course_code)
    {
        $subject = subject::where('course_code', $subject_course_code)->first();
        return view('pages.admin.manage_subject.create_classroom', compact('subject_course_code', 'subject'));
    }

    public function storeClassromm($subject_course_code, Request $request)
    {
        $request->validate([
            'name' => 'required',

        ]);



        classroom::create([
            'name' => $request->name,
            'subject_course_code' => $subject_course_code
        ]);
        Alert::success('Success', 'Data Berhasil Ditambahkan');
        return back();
    }

    public function destroyClassroom($id)
    {
        $classroom = classroom::where('id', $id)->first();
        $classroom->delete();
        Alert::success('Success', 'Data Berhasil Dihapus');
        return back();
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
        return view('pages.admin.manage_subject.create', compact('majors', 'semesters'));
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
        ], [
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
        return view('pages.admin.manage_subject.edit', compact('majors', 'semesters', 'subject'));
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

        $check = subject::where('course_code', $request->course_code)->first();
        if ($check) {
            if ($subject->course_code != $request->course_code) {
                Alert::alert('Fail', 'Course Code Tidak Boleh Sama');
                return redirect()->route('ManageSubject.index');
            }
        }

        $request->validate([
            'course_code' => 'required',
            'full_name' => 'required',
            'nickname' => 'required',
            'sks' => 'required',
        ]);

        $subject->update([
            'course_code' => $request->course_code,
            'full_name' => $request->full_name,
            'nickname' => $request->nickname,
            'sks' => $request->sks,
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

    public function dataLecturer($classrooms_id)
    {

        $duplicates = lecturer_subject::select('lecturer_nip', 'classrooms_id')
            ->selectRaw('COUNT(*) as count')
            ->groupBy('lecturer_nip', 'classrooms_id')
            ->having('count', '>', 1)
            ->get();

        foreach ($duplicates as $duplicate) {
            lecturer_subject::where('lecturer_nip', $duplicate->lecturer_nip)
                ->where('classrooms_id', $duplicate->classrooms_id)
                ->whereNotIn('id', function ($query) use ($duplicate) {
                    $query->selectRaw('MIN(id)')
                        ->from('lecturer_subjects')
                        ->where('lecturer_nip', $duplicate->lecturer_nip)
                        ->where('classrooms_id', $duplicate->classrooms_id);
                })->delete();
        }
        $lecturers = lecturer_subject::where('classrooms_id', $classrooms_id)->paginate(10);
        $lecturerss = lecturer::get();

        $classroom = classroom::where('id', $classrooms_id)->first();

        return view('pages.admin.manage_subject.dataLecturer', compact('lecturers', 'classrooms_id', 'lecturerss', 'classroom'));
    }

    public function dataLecturerStore(Request $request, $classrooms_id)
    {

        if ($request->lecturer_nip == 0) {
            Alert::warning('Warning ', 'Harus Memilih Dosen');
        } else {
            lecturer_subject::create([
                'lecturer_nip' => $request->lecturer_nip,
                'classrooms_id' => $classrooms_id,
            ]);
        }
        return back();
    }


    public function dataLecturerDestroy($id)
    {
        $lecturers = lecturer_subject::findOrFail($id);
        $lecturers->delete();
        Alert::success('Success', 'Data Berhasil Dihapus');
        return back();
    }

    public function dataStudent(Request $request, $classrooms_id)
    {
        $duplicates = student_subject::select('student_nsn', 'classrooms_id')
            ->selectRaw('COUNT(*) as count')
            ->groupBy('student_nsn', 'classrooms_id')
            ->having('count', '>', 1)
            ->get();

        foreach ($duplicates as $duplicate) {
            student_subject::where('student_nsn', $duplicate->student_nsn)
                ->where('classrooms_id', $duplicate->classrooms_id)
                ->whereNotIn('id', function ($query) use ($duplicate) {
                    $query->selectRaw('MIN(id)')
                        ->from('student_subjects')
                        ->where('student_nsn', $duplicate->student_nsn)
                        ->where('classrooms_id', $duplicate->classrooms_id);
                })->delete();
        }

        $lastSetting = setting::all()->last();
        $setting = setting::findOrfail($lastSetting->id);

        $students = student_subject::where('classrooms_id', $classrooms_id)->where('year',  $setting->year)->paginate(10);

        if ($request->has('search')) {
            $students = student_subject::where('student_nsn', 'LIKE', '%' . $request->search . '%')->where('classrooms_id', $classrooms_id)->paginate(10);
        }

        $classroom = classroom::where('id', $classrooms_id)->first();
        // dd($classroom->subject->full_name);

        return view('pages.admin.manage_subject.dataStudent', compact('students', 'classrooms_id', 'classroom'));
    }

    public function dataStudentCreate($classrooms_id)
    {
        $classroom = classroom::where('id', $classrooms_id)->first();

        return view('pages.admin.manage_subject.dataStudentCreate', compact('classrooms_id', 'classroom'));
    }

    public function dataStudentStore($classrooms_id, Request $request)
    {
        $request->validate([
            'student_nsn' => 'required'
        ]);

        $lastSetting = setting::all()->last();
        $setting = setting::findOrfail($lastSetting->id);

        student_subject::create([
            'student_nsn' => $request->student_nsn,
            'classrooms_id' => $classrooms_id,
            'year' => $setting->year
        ]);

        Alert::success('Success', 'Data Berhasil Ditambahkan');
        return back();
    }

    public function import(Request $request, $classrooms_id)
    {
        $lastSetting = setting::all()->last();
        $setting = setting::findOrfail($lastSetting->id);
        $file =  $request->file('file');
        $classrooms_id = intval($classrooms_id);
        (new StudentSubjectImport($classrooms_id, $setting->year))->import($file);

        return back();
    }

    public function downloadTemplate()
    {
        $templatePath = public_path('template/template_import_student_to_subject.xlsx');
        return response()->download($templatePath, 'template_untuk_import_mahasisswa_ke_matakuliah.xlsx');
    }

    public function dataStudentDestroy($id)
    {
        $lecturers = student_subject::findOrFail($id);
        $lecturers->delete();
        Alert::success('Success', 'Data Berhasil Dihapus');
        return back();
    }
}

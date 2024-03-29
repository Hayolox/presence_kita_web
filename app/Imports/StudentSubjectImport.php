<?php

namespace App\Imports;

use App\Models\student;
use App\Models\student_subject;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithValidation;

use Maatwebsite\Excel\Concerns\ToModel;

class StudentSubjectImport implements ToCollection, WithHeadingRow
{
    use Importable;

    protected $classrooms_id;
    protected $year;

    public function __construct($classrooms_id, $year)
    {
        $this->classrooms_id = $classrooms_id;
        $this->year = $year;
    }


    public function collection(Collection $rows)
    {

        foreach ($rows as $row)
        {
            $nsn = strval($row['nim']);
            $student = student::where('nsn',$nsn)->first();
            if($student){
                student_subject::create([
                    'student_nsn'     =>  $nsn,
                    'classrooms_id'    => $this->classrooms_id,
                    'year' => $this->year
                ]);
            }

        }

    }
}

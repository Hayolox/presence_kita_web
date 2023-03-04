<?php

namespace App\Imports;

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

    protected $subject_course_code;

    public function __construct($subject_course_code)
    {
        $this->subject_course_code = $subject_course_code;
    }


    public function collection(Collection $rows)
    {
        foreach ($rows as $row)
        {
            student_subject::create([
                'student_nsn'     => $row['nim'],
                'subject_course_code'    => $this->subject_course_code,
            ]);
        }

    }
}

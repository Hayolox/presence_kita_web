<?php

namespace App\Imports;

use App\Models\setting;
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

    public function __construct($classrooms_id)
    {
        $this->classrooms_id = $classrooms_id;

    }


    public function collection(Collection $rows)
    {
        $lastSetting = setting::all()->last();
        $setting = setting::findOrfail($lastSetting->id);
        foreach ($rows as $row)
        {
            student_subject::create([
                'student_nsn'     => $row['nim'],
                'classrooms_id'    => $this->classrooms_id,
                'year' => 2021
            ]);
        }

    }
}

<?php

namespace App\Imports;

use App\Models\student;
use App\Models\student_pratikum;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithValidation;



class StudentPratikumImport implements ToCollection, WithHeadingRow
{
    use Importable;

    protected $classroomspratikum_id;
    protected $year;

    public function __construct($classroomspratikum_id, $year)
    {
        $this->classroomspratikum_id = $classroomspratikum_id;
        $this->year = $year;
    }


    public function collection(Collection $rows)
    {
        foreach ($rows as $row)
        {
            $nsn = strval($row['nim']);
            $student = student::where('nsn',$nsn)->first();
            if($student){
                student_pratikum::create([
                    'student_nsn'     =>  $nsn,
                    'classroomspratikum_id'    => $this->classroomspratikum_id,
                    'year' => $this->year
                ]);
            }

        }

    }
}

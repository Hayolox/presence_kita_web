<?php

namespace App\Imports;

use App\Models\student;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithValidation;

class StudentsImport implements ToCollection, WithHeadingRow,WithValidation
{

    use Importable;


    public function collection(Collection $rows)
    {
        foreach ($rows as $row)
        {
            student::create([
                'nsn'     => $row['nim'],
                'name'    => $row['name'],
                'generation' => $row['generation'],
                'password' => Hash::make($row['nim']),
                'major_id' => $row['major_id'],
            ]);

        }

    }

    public function rules(): array
    {
        return [
            '*.nim' => ['unique:students,nsn'],
        ];
    }
}

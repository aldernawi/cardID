<?php

namespace App\Imports;

use App\Models\StudentSubject;
use Maatwebsite\Excel\Concerns\ToModel;

class SubjectsImport implements ToModel
{
    public function model(array $row)
    {
        return new StudentSubject([
            'subject_name' => $row[0],
        ]);
    }
}

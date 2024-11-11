<?php

namespace App\Imports;

use App\Models\Student;
use App\Models\StudentSubject;
use Maatwebsite\Excel\Concerns\ToModel;

class StudentSubjectsImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $student = Student::where('student_number', $row[0])->first();
        if($student){
            return new StudentSubject([
                'student_number' => $student->student_number,
                'subject_name' => $row[1],
                'subject_code' => $row[2],

            ]);
        }
        return null;
    }
}
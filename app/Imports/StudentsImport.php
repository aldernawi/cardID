<?php

namespace App\Imports;

use App\Models\Student;
use Maatwebsite\Excel\Concerns\ToModel;

class StudentsImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    { 
        try {
            $student = Student::where('student_number', $row[1])->first();
            if($student){
                return $student;
            }
        } catch (\Throwable $th) {
            return null;
        }
        return new Student([
            'name' => $row[0],
            'student_number' => $row[1],
        ]);
    }
}

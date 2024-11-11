<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentSubject extends Model
{
    use HasFactory;

    protected $fillable = ['student_number', 'subject_code','subject_name'];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_number', 'student_number');
    }

    public function exams()
    {
        return $this->hasMany(Exam::class, 'subject_code', 'subject_code');
    }
}

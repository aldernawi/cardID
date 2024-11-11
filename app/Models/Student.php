<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'student_number', 'image'];

    public function studentSubjects()
    {
        return $this->hasMany(StudentSubject::class, 'student_number', 'student_number');
    }
}

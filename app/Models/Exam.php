<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    protected $fillable = ['subject_code', 'start_date', 'end_date'];


    public function subject()
    {
        return $this->belongsTo(StudentSubject::class, 'subject_code', 'subject_code');
    }
}


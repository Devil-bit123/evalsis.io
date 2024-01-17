<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class teacherCourse extends Model
{
    use HasFactory;

    static $rules = [
        'teacher_id' => 'required',
        'course_id' => 'required',

    ];

    protected $perPage = 20;

    protected $table = 'teacher_courses';
}

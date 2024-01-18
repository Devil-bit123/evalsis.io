<?php

namespace App\Models;

use App\Course;
use App\Teacher;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class teacherCourses extends Model
{
    use HasFactory;

    static $rules = [
        'teacher_id' => 'required',
        'course_id' => 'required',

    ];

    protected $fillable = ['teacher_id','course_id'];

    protected $perPage = 20;

    protected $table = 'teacher_courses';


    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'teacher_id');
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }


}

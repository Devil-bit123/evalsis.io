<?php

namespace App\Models;

use App\Course;
use App\Teacher;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class teacherCourses extends Model
{
    use HasFactory;

    public static function getRules($courseId = null)
    {
        return [
            'teacher_id' => 'required|unique:teacher_courses,teacher_id,NULL,id,course_id,' . $courseId,
            'course_id' => 'required|exists:courses,id',
        ];
    }

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

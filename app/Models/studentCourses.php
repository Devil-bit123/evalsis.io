<?php

namespace App\Models;

use App\Course;
use App\Teacher;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class studentCourses extends Model
{
    use HasFactory;



    static $rules = [
        'student_id' => 'required',
        'course_id' => 'required',

    ];

    protected $fillable = ['student_id','course_id'];

    protected $perPage = 20;

    protected $table = 'student_course';


    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'student_id');
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }


}

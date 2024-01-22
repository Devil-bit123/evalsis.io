<?php

namespace App;

use App\Models\test;
use App\Models\planification;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Course
 *
 * @property $id
 * @property $name
 * @property $description
 * @property $created_at
 * @property $updated_at
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Course extends Model
{

    static $rules = [
		'name' => 'required',
		'description' => 'required',
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['name','description'];

// En el modelo Course
public function teachers()
{
    return $this->belongsToMany(Teacher::class, 'teacher_courses', 'course_id', 'teacher_id');
}

public function students()
{
    return $this->belongsToMany(Student::class, 'student_course', 'course_id', 'student_id');
}

public function planifications()
{
    return $this->hasMany(planification::class, 'course_id');
}

public function tests()
{
    return $this->hasMany(test::class, 'id_course');
}

}

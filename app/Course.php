<?php

namespace App;

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



}

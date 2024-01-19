<?php

namespace App;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Teacher
 *
 * @property $id
 * @property $idTeacher
 * @property $info
 * @property $created_at
 * @property $updated_at
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Teacher extends Model
{

    protected $primaryKey = 'idTeacher';

    static $rules = [
        'idTeacher' => 'required',
        'info.ci' => 'required|numeric|digits_between:1,13',
        'info.fecha_na' => 'required|date_format:Y-m-d',
        'info.tel' => 'required|numeric|digits_between:1,10',
        'info.curso' => 'nullable',
    ];



    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['idTeacher','info'];


    public function user()
    {
        return $this->belongsTo(User::class, 'idTeacher');
    }

// En el modelo Teacher
public function courses()
{
    return $this->belongsToMany(Course::class, 'teacher_courses', 'teacher_id', 'course_id');
}



}

<?php

namespace App;

use App\Models\User;
use App\Models\response;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Student
 *
 * @property $id
 * @property $idStudent
 * @property $info
 * @property $created_at
 * @property $updated_at
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Student extends Model
{


    protected $primaryKey = 'idStudent';

    static $rules = [
		'idStudent' => 'required',
		'info.ci' => 'required|numeric|digits_between:1,10',
		'info.fecha_na' => 'required|date_format:Y-m-d',
		'info.tel' => 'required|numeric|digits_between:1,10',
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['idStudent','info'];


    public function courses()
    {
        return $this->belongsToMany(Course::class, 'student_course', 'student_id', 'course_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'idStudent');
    }

    public function response()
    {
        return $this->hasOne(response::class, 'id_student');
    }

}

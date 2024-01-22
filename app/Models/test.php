<?php

namespace App\Models;

use App\Course;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class test extends Model
{
    use HasFactory;

    protected $table = 'tests';


    static $rules = [
        'id_course' => 'required',
        'json' => 'required',
        'date' => 'required|date',
        'status' => 'required',
        'crono' => 'nullable',
    ];

    protected $fillable = ['id_course','json','date','status','crono'];

    protected $perPage = 20;


    public function course()
    {
        return $this->belongsTo(Course::class, 'id_course');
    }

    public function response()
    {
        return $this->hasOne(Response::class, 'id_test');
    }

}

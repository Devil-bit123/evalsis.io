<?php

namespace App\Models;

use App\Student;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class response extends Model
{
    use HasFactory;

    protected $table = 'responses';

    static $rules = [
        'id_course' => 'required',
        'id_student' => 'required',
        'id_test' => 'required',
        'json' => 'required',
        'score' => 'nullable',
        'status' => 'required',
        'qualify_status' => 'required',
    ];

    protected $fillable = ['id_course','id_student','id_test','json','score','status','qualify_status'];

    public function test()
    {
        return $this->belongsTo(Test::class, 'id_test');
    }

    public function student()
    {
        return $this->belongsTo(Student::class, 'id_student');
    }

}

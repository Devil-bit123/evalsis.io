<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
    ];

    protected $fillable = ['id_course','id_student','id_test','json','score','status'];

    public function test()
    {
        return $this->belongsTo(Test::class, 'id_test');
    }
}

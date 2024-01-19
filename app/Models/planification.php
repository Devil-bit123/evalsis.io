<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class planification extends Model
{
    use HasFactory;

    static $rules = [
        'course_id' => 'required',
        'name' => 'required',
        'description' => 'required',
        'file' => 'nullable|mimes:pdf,xls,xlsx',
    ];

    protected $fillable = ['course_id','name','description','file'];

    protected $table = 'planifications';
}

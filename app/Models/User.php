<?php

namespace App\Models;

use App\Student;
use App\Teacher;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends \TCG\Voyager\Models\User
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // En tu modelo User.php
    public function hasRole($rol)
    {
        return $this->rol == $rol;
    }


    public function teacher()
    {
        return $this->hasOne(Teacher::class, 'idTeacher', 'id');
    }

    public function hasTeacher()
    {
        return !is_null($this->teacher);
    }

    public function student()
    {
        return $this->hasOne(Student::class, 'idStudent', 'id');
    }

    public function hasStudent()
    {
        return !is_null($this->student);
    }

}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Company
 *
 * @property $id
 * @property $info
 * @property $created_at
 * @property $updated_at
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Company extends Model
{

    static $rules = [
        'info.nombre' => 'required|string',
        'info.razon_social' => 'required|string',
        'info.direccion' => 'required|string',
        'info.ruc' => 'required|numeric|max:13',
        'info.telefono' => 'required|numeric|max:10',
    ];


    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['info'];



}

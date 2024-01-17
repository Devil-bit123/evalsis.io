<?php

namespace App\Http\Controllers;

use App\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class inscriptionController extends Controller
{
    //
    public function create()
{


    return view('inscription.create', compact('user', 'courses'));
}

public function store(){

}

}

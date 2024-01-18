<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\inscriptionController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();

    Route::resource('companies', App\Http\Controllers\CompanyController::class);
    Route::resource('teachers', App\Http\Controllers\TeacherController::class);
    Route::resource('students', App\Http\Controllers\StudentController::class);
    Route::get('/inscription', [App\Http\Controllers\inscriptionController::class, 'create'])->name('inscription.create');
    Route::post('/inscription/store', [inscriptionController::class, 'store'])->name('inscription.store');
    Route::any('/inscription/validador', [inscriptionController::class, 'validador'])->name('inscription.validador');


});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');



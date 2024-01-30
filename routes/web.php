<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\inscriptionController;
use App\Http\Controllers\matriculationController;


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

    //Inscripciones de docentes a cursos
    Route::get('/inscription', [App\Http\Controllers\inscriptionController::class, 'create'])->name('inscription.create');
    Route::post('/inscription/store', [inscriptionController::class, 'store'])->name('inscription.store');


    //Matriculaciones de alumnos a cursos
    Route::get('/matriculation', [App\Http\Controllers\matriculationController::class, 'create'])->name('matriculation.create');
    Route::post('/matriculation/store', [matriculationController::class, 'store'])->name('matriculation.store');
    Route::get('/matriculation/delete/', [App\Http\Controllers\matriculationController::class, 'view'])->name('matriculation.view');
    Route::get('matriculation/take-teacher/{course_id}', [App\Http\Controllers\matriculationController::class, 'obtenerDocentes'])->name('take.teacher');
    Route::post('/matriculation/destroy/{course_id}/{id}', [App\Http\Controllers\matriculationController::class, 'delete'])->name('matriculation.delete');


    //Planificacion
    Route::get('/assigneds/{id}', [App\Http\Controllers\assignedCoursesController::class, 'show'])->name('assigned.show');
    Route::any('/assigneds/planification/{id}', [App\Http\Controllers\assignedCoursesController::class, 'add'])->name('assigned.add');
    Route::post('/assigneds/planification-save/{id}', [App\Http\Controllers\assignedCoursesController::class, 'store'])->name('assigned.store');

    //Evaluation
    Route::get('/evaluations/{id}', [App\Http\Controllers\evaluationController::class, 'create'])->name('evaluation.create');
    Route::get('/evaluations/show/{id}', [App\Http\Controllers\evaluationController::class, 'show'])->name('evaluation.show');
    Route::any('/evaluations/store/{id}', [App\Http\Controllers\evaluationController::class, 'store'])->name('evaluation.store');
    Route::any('/evaluations/details/{id}', [App\Http\Controllers\evaluationController::class, 'details'])->name('evaluation.details');
    Route::any('/evaluations/update/{id}', [App\Http\Controllers\evaluationController::class, 'update'])->name('evaluation.update');
    Route::any('/evaluations/destroy/{id}', [App\Http\Controllers\evaluationController::class, 'destroy'])->name('evaluation.destroy');
    Route::any('/evaluations/test/{id}', [App\Http\Controllers\evaluationController::class, 'test'])->name('evaluation.test');
    Route::any('/evaluations/save/', [App\Http\Controllers\evaluationController::class, 'save'])->name('evaluation.save');
    Route::any('/evaluations/scores/{id}', [App\Http\Controllers\evaluationController::class, 'scores'])->name('evaluation.scores');
    Route::any('/evaluations/score/{id}', [App\Http\Controllers\evaluationController::class, 'score'])->name('evaluation.score');
    Route::any('/evaluations/qualify/{id}', [App\Http\Controllers\evaluationController::class, 'qualify'])->name('evaluation.qualify');
    Route::any('/evaluations/qualified/{id}', [App\Http\Controllers\evaluationController::class, 'qualified'])->name('evaluation.qualified');



});

Auth::routes();





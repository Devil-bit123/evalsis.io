<?php

namespace App\Http\Controllers;

use App\Course;
use App\Models\studentCourses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class matriculationController extends Controller
{
    //

    public function create(Request $request)
    {
        $user = Auth::user();
        $courses = Course::all();
        return view('matriculation.create', compact('user', 'courses'));
    }

    public function store(Request $request)
{

    // Asignar valores correctamente
    $request->merge(['student_id' => auth()->user()->id]);
    $request->merge(['course_id' => $request->input('curso')]);

    // Validar los datos
    $validatedData = $request->validate(studentCourses::$rules);

    // Crear una nueva instancia de teacherCourses con datos validados
    $matriculation = new studentCourses([
        'student_id' => $request->input('student_id'),
        'course_id' => $request->input('course_id'),
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    // Guardar el objeto en la base de datos
    $matriculation->save();

    // Redireccionar con mensaje de éxito
    return redirect()->route('voyager.courses.index')->with('success', 'Inscripción creada exitosamente');
}

}

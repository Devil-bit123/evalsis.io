<?php

namespace App\Http\Controllers;


use App\Course;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\teacherCourses;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class inscriptionController extends Controller
{
    //
    public function create(Request $request)
{
    $user = Auth::user();
    $courses = Course::all();
    return view('inscription.create', compact('user', 'courses'));
}

public function store(Request $request)
{
    // Asignar valores correctamente
    $request->merge(['teacher_id' => auth()->user()->id]);
    $request->merge(['course_id' => $request->input('curso')]);

    // Validar los datos
    $validatedData = $request->validate(teacherCourses::$rules);

    // Crear una nueva instancia de teacherCourses con datos validados
    $inscription = new teacherCourses([
        'teacher_id' => $request->input('teacher_id'),
        'course_id' => $request->input('course_id'),
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    // Guardar el objeto en la base de datos
    $inscription->save();

    // Redireccionar con mensaje de éxito
    return redirect()->route('voyager.courses.index')->with('success', 'Inscripción creada exitosamente');
}



public function validador(Request $request){
    // Supongamos que tienes un usuario con el id 1 que es profesor
$professorUser = User::find(2);

// Verifica si el usuario es un profesor y tiene asociado un profesor
if ($professorUser->hasTeacher()) {
    // Obtén los cursos asociados al profesor
    $cursosDelProfesor = $professorUser->teacher;
    dd($cursosDelProfesor);

} else {
    dd("Este usuario no es un profesor o no tiene asociado un profesor.");
}

}

}

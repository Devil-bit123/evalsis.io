<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\Validator;
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
    $validator = Validator::make($request->all(), teacherCourses::getRules($request->input('curso')));

    // If validation fails, redirect with error message
    if ($validator->fails()) {
        return redirect()->route('inscription.create')
            ->withErrors(['error' => 'El profesor ya está matriculado en este curso o el curso no existe. Por favor, selecciona otro curso e intenta nuevamente.'])
            ->withInput(); // Mantener los datos ingresados en el formulario.
    }

    // Create a new instance of teacherCourses with validated data
    $inscription = new teacherCourses([
        'teacher_id' => $request->input('teacher_id'),
        'course_id' => $request->input('course_id'),
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    // Save the object to the database
    $inscription->save();

    // Redirect with success message
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

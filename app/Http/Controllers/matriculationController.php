<?php

namespace App\Http\Controllers;

use App\Course;
use Illuminate\Http\Request;
use Laravel\Ui\Presets\React;
use App\Models\studentCourses;
use App\Models\teacherCourses;
use App\Teacher;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

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

    public function view(Request $request){
        $user = Auth::user();
        $courses = Course::all();

        return view('matriculation.view',compact('user', 'courses'));
    }

    public function obtenerDocentes(Request $request, $course_id) {
        // Recupera el ID del docente seleccionado desde la solicitud
        $teacher_id = $request->input('teacher_id');

        $course = Course::find($course_id);
        $teachers = $course->teachers;

        $teacherData = $teachers->map(function ($teacher) {
            return [
                'id' => $teacher->id,
                'idTeacher' => $teacher->idTeacher,
                'name' => $teacher->user->name,
            ];
        });

        return response()->json($teacherData);
    }




    public function delete(Request $request)
    {
        // Renombra el campo "docente" a "teacher_id"
        $request->merge(['teacher_id' => $request->input('docente')]);
        $request->merge(['course_id' => $request->input('curso')]);

        $teacher = Teacher::where('id','=', $request->input('teacher_id'))->first();

        $teacherCourse = teacherCourses::where([
            'teacher_id' => $teacher->idTeacher,
            'course_id' => $request->input('course_id'),
        ])->first();
        if ($teacherCourse) {
            // Elimina la relación entre el profesor y el curso
            $teacherCourse->delete();
            return redirect()->route('voyager.courses.index')->with('success', 'Teacher deleted successfully');
        } else {
            return redirect()->route('voyager.courses.index')->with('error', 'Teacher relation not found');
        }

    }
}

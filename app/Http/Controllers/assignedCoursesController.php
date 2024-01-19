<?php

namespace App\Http\Controllers;

use App\Course;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\planification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class assignedCoursesController extends Controller
{
    //
    public function show($id) {

        $user = Auth::user();

        $course = Course::find($id);

        // Assuming $course->teachers is a collection of teachers associated with the course
        $teachers = $course->teachers;

        $students = $course->students;

        // Fetch names of all teachers
        $teacherNames = $teachers->map(function ($teacher) {
            return $teacher->user->name;
        });


        $studentNames = $students->map(function ($student) {
            return $student->user->name;
        });



        return view('assigned.show', ['course' => $course, 'teacherNames' => $teacherNames, 'studentNames' => $studentNames,'user'=>$user]);
    }

    public function add(Request $request, $id){



        $user = Auth::user();
        $course = Course::find($id);

        return view('planification.add',compact('course','user'));
    }

    public function store(Request $request, $id)
    {
        $course = Course::find($id);

        // Validar los datos del formulario
        $request->merge(['course_id' => $id]);

        $validatedData = $request->validate(Planification::$rules);
        $planification = new Planification();
        $planification->course_id = $id;
        $planification->name = $request->input('name');
        $planification->description = $request->input('description');


        if($request->hasFile('file')){

            $file = $request->file('file');

            $currentDate = now()->format('YmdHis');
            $planSlug = Str::slug($request->input('name'));
            $courseSlug = Str::slug($course->name);
            $fileExtension = $file->getClientOriginalExtension();
            $filename = $planSlug.'__'.$currentDate.'.'.$fileExtension;


            $filePath = $file->storeAs("public/{$courseSlug}", $filename);
            $planification->file = asset("storage/{$courseSlug}/{$filename}");

        }
        $planification->save();

        // Redirigir a la vista deseada o realizar alguna acción
        return redirect()->route('assigned.show', ['id' => $course->id]);
    }



}

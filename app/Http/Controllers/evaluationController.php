<?php

namespace App\Http\Controllers;

use App\Course;
use App\Models\response;
use App\Models\test;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class evaluationController extends Controller
{
    //
    public function show($id)
    {
        $course = Course::find($id);
        return view('evaluation.show', compact('course'));
    }

    public function details($id)
    {
        // Buscar el test por su ID
        $tests = Test::findOrFail($id);
        $course = $tests->course;
        //dd($tests);
        return view('evaluation.details', compact('tests', 'course'));
    }


    public function create($id)
    {
        $course = Course::find($id);
        //dd($course);
        return view('evaluation.create', compact('course'));
    }

    public function store(Request $request, $id)
    {
        $request->merge(['status' => 'new']);

        if ($request->has('crono')) {
            $crono = $request->input('crono');
            $totalMinutos = 60; // Valor predeterminado en caso de que 'crono' no esté presente

            if (strpos($crono, ':') !== false) {
                list($horas, $minutos) = explode(":", $crono);
                $totalMinutos = ($horas * 60) + $minutos;
            }

            $request->merge(['crono_minutes' => $totalMinutos]);
        } else {
            $request->merge(['crono_minutes' => 60]);
        }

        $validatedData = $request->validate(Test::$rules);

        //dd($request);

        $test = new Test([
            'id_course' => $request->input('id_course'),
            'json' => json_encode($request->input('json')),
            'date' => $request->input('date'),
            'status' => $request->input('status'),
            'crono' => $request->input('crono_minutes'),
        ]);

        $test->save();

        return redirect()->route('voyager.tests.index');
    }

    public function update(Request $request, $id)
    {
        $request->merge(['status' => 'new']);
        $test = test::find($id);

        if ($request->has('crono')) {
            $crono = $request->input('crono');
            $totalMinutos = 60; // Valor predeterminado en caso de que 'crono' no esté presente

            if (strpos($crono, ':') !== false) {
                list($horas, $minutos) = explode(":", $crono);
                $totalMinutos = ($horas * 60) + $minutos;
            }

            $request->merge(['crono_minutes' => $totalMinutos]);
        } else {
            $request->merge(['crono_minutes' => 60]);
        }

        $validatedData = $request->validate(Test::$rules);

        //dd($test);
        $test->id_course = $request->input('id_course');
        $test->json = json_encode($request->input('json'));
        $test->date = $request->input('date');
        $test->status = $request->input('status');
        $test->crono = $request->input('crono_minutes');

        // Guardar el test actualizado
        $test->save();

        return redirect()->route('voyager.tests.index');
    }

    public function destroy($id)
    {
        $test = Test::find($id);

        if ($test) {

            $test->delete();

            return redirect()->route('voyager.tests.index')->with('success', 'Test eliminado exitosamente.');
        } else {
            return redirect()->route('voyager.tests.index')->with('error', 'No se encontró el Test con el ID proporcionado.');
        }
    }

    public function test($id){
        $user = Auth::user();
        $test = test::find($id);
        return view('evaluation.test', compact('user','test'));
    }

    public function save(Request $request){
        $user = Auth::user();
        $validatedData = $request->validate(response::$rules);
        $response = new response([
            'id_course' => $request->input('id_course'),
            'id_student' => $request->input('id_student'),
            'json' => json_encode($request->input('json')),
            'status' => $request->input('status'),
            'id_test' => $request->input('id_test'),
        ]);
        $response->save();

    }

}
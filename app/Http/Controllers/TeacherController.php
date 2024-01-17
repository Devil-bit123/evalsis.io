<?php

namespace App\Http\Controllers;

use App\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


/**
 * Class TeacherController
 * @package App\Http\Controllers
 */
class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $teachers = Teacher::paginate();

        return view('teacher.index', compact('teachers'))
            ->with('i', (request()->input('page', 1) - 1) * $teachers->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $teacher = new Teacher();
        return view('teacher.create', compact('teacher'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $userId = Auth::id();

        // Obtén la solicitud actual
        $requestData = $request->all();

        // Agrega el índice "idTeacher" con el valor de $userId
        $requestData['idTeacher'] = $userId;

        // Actualiza la solicitud con el nuevo dato
        $request->merge($requestData);

        $validatedData = $request->validate(Teacher::$rules);

        if (!$validatedData) {
            return redirect()->route('teacher.create')
                ->withErrors(['error' => 'No se pudo guardar el registro. Por favor, revisa los datos e intenta nuevamente.'])
                ->withInput(); // Mantener los datos ingresados en el formulario.
        }
        //dd($request);
        $data = $request->all();
        DB::table('teachers')->insert([
            'idTeacher' => $request->input('idTeacher'),
            'info' => json_encode($data['info']),
        ]);
        return redirect()->route('voyager.custom-dashboards.index')
            ->with('success', 'Company created successfully.');
    }


    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $teacher = Teacher::find($id);

        return view('teacher.show', compact('teacher'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $teacher = Teacher::find($id);

        return view('teacher.edit', compact('teacher'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Teacher $teacher
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Teacher $teacher)
    {
        request()->validate(Teacher::$rules);

        $teacher->update($request->all());

        return redirect()->route('teachers.index')
            ->with('success', 'Teacher updated successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $teacher = Teacher::find($id)->delete();

        return redirect()->route('teachers.index')
            ->with('success', 'Teacher deleted successfully');
    }
}

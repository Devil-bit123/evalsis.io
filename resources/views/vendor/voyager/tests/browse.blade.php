@extends('voyager::master')

@section('content')

    @auth


        @php
            $user = Auth::user();
            $courses = \App\Course::all();
        @endphp
        @if ($user->role && $user->role->name == 'admin')
            <div class="container">
                <p>Los cursos disponibles son:</p>

                <div class="row">
                    @foreach ($courses as $course)
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="card shadow">
                                <div class="card-header">
                                    <!-- Puedes agregar contenido al encabezado de la tarjeta si es necesario -->
                                </div>
                                <div class="card-body" style="height: 200px; overflow: hidden;">
                                    <h5 class="card-title">{{ $course->name }}</h5>
                                    <a href="{{ route('evaluation.create', ['id' => $course->id]) }}"
                                        class="btn btn-primary">Agregar Test</a>
                                    <a href="{{ route('evaluation.show', ['id' => $course->id]) }}" class="btn btn-primary">Ver
                                        Tests</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!--FIN ADMIN-->
        @elseif ($user->role && $user->role->name == 'docente')
            @php
                $user = Auth::user();
                $teacher = $user->teacher->courses;
            @endphp

            <p>Los cursos en los que eres docente son:</p>
            <div class="row">
                @foreach ($teacher as $course)
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <div class="card-header">
                                <!-- Card Header Content -->
                            </div>
                            <div class="card-body" style="height: 200px; overflow: hidden;">
                                <h5 class="card-title">{{ $course->name }}</h5>
                                <p class="card-text">{{ $course->description }}</p>
                                <a href="{{ route('evaluation.create', ['id' => $course->id]) }}"
                                    class="btn btn-primary">Agregar Test</a>
                                <a href="{{ route('evaluation.show', ['id' => $course->id]) }}" class="btn btn-primary">Ver
                                    Tests</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>


            <!--FIN DOCENTE-->
        @elseif ($user->role && $user->role->name == 'alumno')
            @php
                $user = Auth::user();
                $student = $user->student;

                $fechaActual = Carbon\Carbon::now();

                // Obtener todos los tests asociados con los cursos del estudiante
                $tests = collect();

                foreach ($student->courses as $course) {
                    $tests = $tests->merge($course->tests);
                }

                $testsWithoutResponse = \App\Models\test::whereDoesntHave('responses', function ($query) use ($user) {
                    $query->where('id_student', $user->id);
                })
                ->where('date','=', $fechaActual)
                ->get();

                $testsWithResponse = \App\Models\test::whereHas('responses', function ($query) use ($user) {
                    $query->where('id_student', $user->id);
                })
                ->get();

                //dd($testsWithoutResponse);

            @endphp


            <div class="row">
                @foreach ($testsWithoutResponse as $test)
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">{{ $test->course->name }}</h5>
                                <p class="card-text">{{ $test->date }}</p>
                                <a href="{{ route('evaluation.test', ['id' => $test->id]) }}" class="btn btn-danger">Tomar
                                    prueba</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>


            <div class="card">
                <div class="card-body">
                    <h4><strong>Exámenes calificados</strong></h4>
                </div>
            </div>
            <div class="row">
                @foreach ($testsWithResponse as $test)
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">{{ $test->course->name }}</h5>
                                <p class="card-text">Fecha de test: {{ $test->date }}</p>
                                <a href="{{ route('evaluation.qualified', ['id' => $test->id]) }}" class="btn btn-warning">Ver califición</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!--FIN ALUMNO-->
        @endif
    @endauth

@stop

@extends('voyager::master')

@section('page_header')
    @php
        $user = Auth::user();
        $courses = App\Course::all();
    @endphp
    <div class="container text-center">
        <div class="row">
            <div class="col">

                <h3>Hola, {{ $user->name }}</h3>

            </div>
            <div class="col">
                @if ($user->role && $user->role->name == 'admin')
                    <p>Los cursos disponibles son:</p>
                    <div class="row">
                        @foreach ($courses as $course)
                            <div class="col-md-4 mb-4">
                                <div class="card">
                                    <div class="card-header">
                                        <!-- Card Header Content -->
                                    </div>
                                    <div class="card-body" style="height: 200px; overflow: hidden;">
                                        <h5 class="card-title">{{ $course->name }}</h5>
                                        <p class="card-text">{{ $course->description }}</p>
                                        <a href="#" class="btn btn-primary">Ver Aula</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @elseif ($user->role && $user->role->name == 'docente')
                    @if ($user->hasTeacher() && $user->teacher->courses)
                        <p>Los cursos en los que eres docente son:</p>
                        <div class="row">
                            @foreach ($user->teacher->courses as $course)
                                <div class="col-md-4 mb-4">
                                    <div class="card">
                                        <div class="card-header">
                                            <!-- Card Header Content -->
                                        </div>
                                        <div class="card-body" style="height: 200px; overflow: hidden;">
                                            <h5 class="card-title">{{ $course->name }}</h5>
                                            <p class="card-text">{{ $course->description }}</p>
                                            <a href="#" class="btn btn-primary">Ver Aula</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                @elseif ($user->role && $user->role->name == 'alumno')
                    @if ($user->hasStudent() && $user->student->courses)

                        <p>Los cursos en los que estas matriculado son:</p>
                        <div class="row">
                            @foreach ($user->student->courses as $course)
                                <div class="col-md-4 mb-4">
                                    <div class="card">
                                        <div class="card-header">
                                            <!-- Card Header Content -->
                                        </div>
                                        <div class="card-body" style="height: 200px; overflow: hidden;">
                                            <h5 class="card-title">{{ $course->name }}</h5>
                                            <p class="card-text">{{ $course->description }}</p>
                                            <a href="#" class="btn btn-primary">Ver Aula</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                @endif
            </div>

        </div>
    </div>


@stop

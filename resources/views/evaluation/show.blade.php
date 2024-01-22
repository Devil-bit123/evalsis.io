@extends('voyager::master')

@section('content')
    @auth
        <h3>{{ $course->name }} Tests</h3>
        <p>Acontinuacion se encuentran los test que a creado en su curso:</p>
        @foreach ($course->tests as $test)
            <div class="card">
                <div class="card-body">
                    <strong><p>{{ $test->date }}</p></strong>
                     <a href="{{ route('evaluation.destroy', ['id' => $test->id]) }}"
                        class="btn btn-danger">Eliminar</a>
                    <a href="{{ route('evaluation.details', ['id' => $test->id]) }}" class="btn btn-warning">Editar</a>
                </div>
            </div>
        @endforeach





    @endauth
@endsection

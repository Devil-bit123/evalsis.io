@extends('voyager::master')

@section('content')
<div class="card">
    <div class="card-header">
        <h3>Hola, {{ $user->name }}</h3>
    </div>
    <div class="card-body">
        <h5 class="card-title">Por favor selecciona el curso al que deseas inscribirte como maestro</h5>
        <form action="{{ route('inscription.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="curso">Cursos:</label>
                <select name="curso" id="curso" class="form-control">
                    @foreach($courses as $course)
                        <option value="{{ $course->id }}">{{ $course->name }}</option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Inscribirme</button>
        </form>
    </div>
</div>

@stop

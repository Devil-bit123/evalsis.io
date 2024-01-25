@extends('voyager::master')

@section('content')

@auth

<div class="container mt-4">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Selecciona el estudiante que deseas calificar:</h5>
        </div>
        <div class="card-body">
            <div class="row">
                @foreach ($responses as $response)
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">{{ $response->student->user->name }}</h5>
                            <p class="card-text">Fecha de Respuesta: {{ $response->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                        <div class="card-footer">
                            @if ($response->qualify_status != 'qualified')
                            <a href="{{ route('evaluation.score', ['id' => $response->id]) }}" class="btn btn-warning">Calificar</a>
                            @endif

                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

@endauth


@endsection

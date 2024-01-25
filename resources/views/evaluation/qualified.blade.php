@extends('voyager::master')

@section('content')
    @auth

        <div class="container mt-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">{{ $response->test->course->name }}</h5>
                </div>
                <div class="card-body">
                    <h5 class="card-title">Test realizado el {{ $response->test->date }}</h5>
                    <p>Has respondido el test de manera: {{ $response->status }}</p>
                    @foreach ($questionsAndAnswers as $qa)
                        <div class="card mb-3">
                            <div class="card-body">
                                <h6 class="card-subtitle mb-2 text-muted">Pregunta:</h6>
                                <p class="card-text">{{ $qa['pregunta'] }}</p>
                                <h6 class="card-subtitle mb-2 text-muted">Respuesta:</h6>
                                <p class="card-text">{{ $qa['respuesta'] }}</p>
                                <p class="card-text">{{ $qa['correccion'] }}</p>
                            </div>
                        </div>
                    @endforeach

                    <div class="mb-3">
                        <label for="formGroupExampleInput" class="form-label">Calificación</label>
                        <input class="form-control" type="text" placeholder="{{ $response->score }}"
                            aria-label="Disabled input example" disabled>
                    </div>

                    <button type="button" class="btn btn-warning" id="calificarBtn" onclick="irARuta()">Volver</button>
                </div>
            </div>
        </div>
        <script>
            function irARuta() {
                var ruta = "{{ route('voyager.tests.index') }}";
                window.location.href = ruta;
            }
        </script>

    @endauth
@endsection

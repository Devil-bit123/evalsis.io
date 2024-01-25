@extends('voyager::master')

@section('content')
    @auth

        <div class="container mt-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Vas a calificar a: {{ $response->student->user->name }}</h5>
                </div>
                <div class="card-body">
                    <p>Este usuario respondió el test de manera: {{ $response->status }}</p>
                    @foreach ($questionsAndAnswers as $qa)
                        <div class="card mb-3">
                            <div class="card-body">
                                <h6 class="card-subtitle mb-2 text-muted">Pregunta:</h6>
                                <p class="card-text">{{ $qa['pregunta'] }}</p>
                                <h6 class="card-subtitle mb-2 text-muted">Respuesta:</h6>
                                <p class="card-text">{{ $qa['respuesta'] }}</p>

                                <!-- Agregar un textarea para la corrección -->
                                <div class="mb-3">
                                    <label for="correccionTextarea{{ $loop->index }}" class="form-label">Corrección:</label>
                                    <textarea class="form-control" id="correccionTextarea{{ $loop->index }}" rows="3"></textarea>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    <div class="input-group mb-3">
                        <span class="input-group-text" id="inputGroup-sizing-default">Score</span>
                        <input type="number" class="form-control" id="scoreInput" aria-label="Sizing example input"
                            inputmode="numeric" aria-describedby="inputGroup-sizing-default">
                    </div>

                    <button type="button" class="btn btn-warning" id="calificarBtn">Calificar</button>
                </div>
            </div>
        </div>


        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

        <script>
            document.getElementById('calificarBtn').addEventListener('click', function() {
                // Obtener el valor del puntaje ingresado
                var scoreInput = document.getElementById('scoreInput').value;

                // Validar que el puntaje sea positivo
                if (scoreInput < 0) {
                    alert('El puntaje debe ser un número positivo.');
                    document.getElementById('scoreInput').value = ''; // Borrar el valor
                    return;
                }

                // Crear un array para almacenar la información de cada pregunta
                var questionsData = [];

                // Iterar sobre todas las preguntas y obtener la corrección de cada una
                @foreach ($questionsAndAnswers as $qa)
                    var correccionTextarea = document.getElementById('correccionTextarea{{ $loop->index }}').value;
                    var questionData = {
                        pregunta: "{{ $qa['pregunta'] }}",
                        respuesta: "{{ $qa['respuesta'] }}",
                        correccion: correccionTextarea
                    };
                    questionsData.push(questionData);
                @endforeach

                // Enviar la solicitud Ajax con el JSON que contiene la información de todas las preguntas
                $.ajax({
                    type: 'POST',
                    url: "{{ route('evaluation.qualify', ['id' => $response->id]) }}",
                    data: {
                        score: scoreInput,
                        questionsData: JSON.stringify(questionsData), // Convertir el array a JSON
                        _token: '{{ csrf_token() }}', // Agregar el token CSRF
                    },
                    success: function(response) {
                        // Log o alerta para verificar que se ha enviado correctamente
                        //console.log('Solicitud Ajax exitosa:', response);
                        var ruta = "{{ route('voyager.tests.index') }}";
                        window.location.href = ruta;
                    },
                    error: function(error) {
                        // Log o alerta para manejar el error
                        console.error('Error al enviar la solicitud Ajax:', error);
                    }
                });

            });

            // Agregar evento de entrada para mostrar retroalimentación en tiempo real
            document.getElementById('scoreInput').addEventListener('input', function() {
                var scoreInput = document.getElementById('scoreInput');
                var scoreValue = parseInt(scoreInput.value);

                if (isNaN(scoreValue)) {
                    scoreInput.setCustomValidity('Ingresa un número válido.');
                } else {
                    scoreInput.setCustomValidity('');
                }
            });
        </script>


        <style>
            /* Ocultar las flechas de aumento y disminución en el campo de entrada numérica */
            input[type=number]::-webkit-inner-spin-button,
            input[type=number]::-webkit-outer-spin-button {
                -webkit-appearance: none;
                margin: 0;
            }

            input[type=number] {
                -moz-appearance: textfield;
            }
        </style>

    @endauth
@endsection

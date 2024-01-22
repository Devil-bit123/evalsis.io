@extends('voyager::master')

@section('content')
    @auth

        <div class="card">
            <div class="card-body">
                <p>Hola, <strong>{{ $user->name }},</strong> tienes <strong>{{ $test->crono }}</strong> minutos para resolver
                    el test; que comenzarán después de que hagas clic en el botón <strong>"Iniciar"</strong></p>
                <button type="button" class="btn btn-danger" id="btn-iniciar">Iniciar</button>
                <div id="contador" style="display: none;">Tiempo restante: <span id="tiempo-restante">{{ $test->crono }}</span>
                    minutos</div>
            </div>
        </div>

        <div id="preguntas-container" style="display: none;">
            @php
                $preguntas = json_decode($test->json);
            @endphp

            <div id="preguntas" data-respuestas="{{ json_encode([]) }}">
                @foreach ($preguntas as $index => $pregunta)
                    <div class="container pregunta" data-index="{{ $index }}" style="display: none;">
                        <div class="card">
                            <div class="card-header">
                                <!-- Puedes mostrar información adicional de la pregunta aquí -->
                            </div>
                            <div class="card-body">
                                <h5 class="card-title">Pregunta</h5>
                                <p class="card-text">{{ $pregunta }}</p>
                                <textarea class="form-control respuesta" placeholder="Ingresa tu respuesta"></textarea>
                                <a href="#" class="btn btn-primary btn-guardar">Guardar Respuesta</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
        <script>
            $(document).ready(function() {
                var tiempoRestante = {{ $test->crono }};
                var intervalId;
                var preguntas = $('.pregunta');
                var respuestas = [];

                $('#btn-iniciar').on('click', function() {
                    $('#btn-iniciar').prop('disabled', true);
                    $('#contador').show();
                    $('#preguntas-container').show(); // Mostrar las preguntas al iniciar
                    mostrarPregunta(0); // Mostrar la primera pregunta
                    intervalId = setInterval(function() {
                        if (tiempoRestante > 0) {
                            tiempoRestante--;
                            $('#tiempo-restante').text(tiempoRestante);
                        } else {
                            clearInterval(intervalId);
                            alert('¡Tiempo agotado! Tu tiempo se agoto, tus respuestas se enviaran para su calificación GRACIAS.');
                            var datosTest = {
                            json: respuestas,
                            id_student: {{ $user->id }},
                            id_test: {{ $test->id }},
                            id_course: {{ $test->id_course }},
                            status: 'partial'
                        };

                            $.ajax({
                            url: '/admin/evaluations/save',
                            method: 'POST',
                            data: datosTest,
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                window.location.href = '{{ route('voyager.tests.index') }}';
                            },
                            error: function(error) {
                                console.error(error);
                            }
                        });


                        }
                    }, 60000); // El intervalo se establece en 1 minuto (60000 milisegundos).
                });

                $('#preguntas-container').on('click', '.btn-guardar', function() {
                    var indexPregunta = $(this).closest('.pregunta').data('index');
                    var respuesta = $(this).closest('.pregunta').find('.respuesta').val();
                    respuestas[indexPregunta] = {
                        pregunta: preguntas.eq(indexPregunta).find('.card-text').text(),
                        respuesta: respuesta
                    };
                    mostrarPregunta(indexPregunta + 1); // Mostrar la siguiente pregunta
                });

                function mostrarPregunta(index) {
                    if (index < preguntas.length) {
                        preguntas.hide();
                        preguntas.eq(index).show();
                    } else {
                        clearInterval(intervalId);
                        alert('¡Has completado todas las preguntas! Serán enviadas para su calificación. GRACIAS.');
                        // Aquí puedes agregar código adicional al completar todas las preguntas.
                        console.log('Respuestas finales:', respuestas);
                        // Aquí puedes enviar las respuestas al servidor (por ejemplo, a través de AJAX).
                        var datosTest = {
                            json: respuestas,
                            id_student: {{ $user->id }},
                            id_test: {{ $test->id }},
                            id_course: {{ $test->id_course }},
                            status: 'complete'
                        };

                        $.ajax({
                            url: '/admin/evaluations/save',
                            method: 'POST',
                            data: datosTest,
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                window.location.href = '{{ route('voyager.tests.index') }}';
                            },
                            error: function(error) {
                                console.error(error);
                            }
                        });
                    }
                }
            });
        </script>

    @endauth
@endsection

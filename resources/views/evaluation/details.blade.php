@extends('voyager::master')

@section('content')
    @auth

        <div class="container text-start">
            <div class="row">
                <div class="col">
                    <h2>{{ $course->name }}</h2>
                </div>
                <div class="col">
                    <div class="card">
                        <div class="card-body">

                            <div class="mb-3">
                                <label for="formGroupExampleInput" class="form-label">Fecha del Test</label>
                                <input type="date" class="form-control" id="formGroupExampleInput"
                                    placeholder="Fecha del Test" value="{{ $tests->date }}">
                            </div>

                            <div class="mb-3">
                                <label for="formGroupExampleInput" class="form-label">Fecha del Test (Cuanto tiempo quieres que
                                    dure tu test
                                    en H:mm)</label>
                                <input type="time" class="form-control" id="formGroupExampleInput"
                                    placeholder="Fecha del Test" value="{{ $tests->crono }}">
                                <p>Si no ingresas el tiempo se <strong>asignaran 60 minutos por defecto.</strong> </p>
                            </div>

                            <h5>Ingresa las preguntas del test</h5>
                            <!-- Cargar las preguntas del JSON -->
                            <div class="container" id="contenedorPreguntas">
                                @php
                                    $preguntas = json_decode($tests->json);
                                @endphp

                                @foreach ($preguntas as $index => $pregunta)
                                    <div class="pregunta mb-3">
                                        <label class="form-label">Pregunta <span
                                                class="num-pregunta">{{ $index + 1 }}</span></label>
                                        <input type="text" class="form-control" placeholder="Ingresa tu pregunta"
                                            value="{{ $pregunta }}">
                                        <button type="button" class="btn btn-danger btn-eliminar">Eliminar Pregunta</button>
                                    </div>
                                @endforeach
                            </div>

                        </div>
                    </div>
                    <button type="button" class="btn btn-warning" id="btn-agregar">Agregar Pregunta</button>
                    <button type="button" class="btn btn-success" id="btn-update">Guardar</button>
                </div>
                <div class="col">
                    Column
                </div>
            </div>
        </div>

    @endauth

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        $(document).ready(function () {

            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });

            // Agregar evento de cambio al campo de fecha del test
            $('#formGroupExampleInput').on('input', function () {
                var fechaTest = new Date($(this).val());
                var fechaActual = new Date();
                fechaActual.setDate(fechaActual.getDate() + 2);

                if (fechaTest <= fechaActual) {
                    alert('La fecha del test debe ser al menos 3 días después de la fecha actual.');
                    $(this).val(''); // Limpiar el campo si la fecha no es válida
                }
            });

            // Manejar eventos de agregar y eliminar preguntas
            $('#btn-agregar').on('click', function () {
                // Clonar la última pregunta presente
                var nuevaPregunta = $('.pregunta:last').clone();
                nuevaPregunta.find('input').val('');

                // Calcular el número de pregunta basado en las preguntas existentes
                var numPreguntas = $('.pregunta').length + 1;
                nuevaPregunta.find('.num-pregunta').text(numPreguntas);

                // Limpiar el evento de clic del botón "Eliminar Pregunta" anterior
                nuevaPregunta.find('.btn-eliminar').off('click');

                // Manejar evento de eliminar para la nueva pregunta
                nuevaPregunta.find('.btn-eliminar').on('click', function () {
                    if (numPreguntas > 1) {
                        $(this).closest('.pregunta').remove();
                        actualizarNumerosPreguntas();
                    }
                });

                // Agregar la nueva pregunta al contenedor
                nuevaPregunta.appendTo('#contenedorPreguntas');
            });

            // Manejar evento de eliminar para preguntas existentes y nuevas preguntas
            $('#contenedorPreguntas').on('click', '.btn-eliminar', function () {
                var numPreguntas = $('.pregunta').length;
                if (numPreguntas > 1) {
                    $(this).closest('.pregunta').remove();
                    actualizarNumerosPreguntas();
                }
            });

            $('#btn-update').on('click', function () {

                var courseId = {{ $course->id }};
                var testId = {{ $tests->id }};
                // Obtener la fecha y hora del test
                var fechaTest = $('#formGroupExampleInput').val();
                var horaTest = $('#tiempoResolucion').val();

                // Crear un array para almacenar las preguntas
                var preguntas = [];
                $('.pregunta').each(function () {
                    preguntas.push($(this).find('input').val());
                });

                // Objeto con los datos a enviar al servidor
                var datosTest = {
                    date: fechaTest,
                    crono: horaTest,
                    id_course: courseId,
                    json: preguntas
                };
                // Realizar la solicitud AJAX
                $.ajax({
                    url: '/admin/evaluations/update/' + testId,
                    method: 'POST',
                    data: datosTest,
                    success: function (response) {
                        window.location.href = '{{ route('voyager.tests.index') }}';
                    },
                    error: function (error) {
                        console.error(error);
                    }
                });
            });

        });

        // Mover la función fuera del ámbito del evento document.ready
        function actualizarNumerosPreguntas() {
            $('.pregunta').each(function (index) {
                $(this).find('.num-pregunta').text(index + 1);
            });
        }
    </script>
@endsection

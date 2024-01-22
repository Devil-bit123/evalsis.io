@extends('voyager::master')

@section('content')
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
                                placeholder="Fecha del Test">
                        </div>

                        <div class="container">
                            <div class="mb-3">
                                <label for="tiempoResolucion" class="form-label">Tiempo de resolución
                                    <!-- Agregar el tooltip aquí -->
                                    <span data-bs-toggle="tooltip" data-bs-placement="top"
                                        title="Ingresa el tiempo en horas y minutos">(Cuanto tiempo quieres que dure tu test
                                        en H:mm)</span>
                                </label>
                                <input type="time" class="form-control" id="tiempoResolucion"
                                    placeholder="Tiempo de resolución" data-bs-toggle="tooltip" data-bs-placement="top"
                                    title="Ingresa el tiempo en horas y minutos">
                                    <p>Si no ingresas el tiempo se <strong>asignaran 60 minutos por defecto.</strong> </p>
                            </div>
                        </div>

                        <h5>Ingresa las preguntas del test</h5>

                        <div class="container" id="contenedorPreguntas">
                            <!-- Template para la pregunta -->
                            <div class="pregunta mb-3">
                                <label class="form-label">Pregunta <span class="num-pregunta">1</span></label>
                                <input type="text" class="form-control" placeholder="Ingresa tu pregunta">
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <button type="button" class="btn btn-danger btn-eliminar">Eliminar</button>
                                </div>
                            </div>
                        </div>

                        <!-- Botón para agregar nuevas preguntas -->
                        <button type="button" class="btn btn-warning" id="btn-agregar">Agregar Pregunta</button>
                        <button type="button" class="btn btn-success" id="btn-guardar-test">Guardar Test</button>
                    </div>
                </div>
            </div>
            <div class="col">
                Column
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        $(document).ready(function() {



            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });


            // Agregar evento de cambio al campo de fecha del test
            $('#formGroupExampleInput').on('input', function() {
                var fechaTest = new Date($(this).val());
                var fechaActual = new Date();
                fechaActual.setDate(fechaActual.getDate() + 2);

                if (fechaTest <= fechaActual) {
                    alert('La fecha del test debe ser al menos 3 días después de la fecha actual.');
                    $(this).val(''); // Limpiar el campo si la fecha no es válida
                }
            });

            // Manejar eventos de agregar y eliminar preguntas
            var numPreguntas = 1;
            $('#btn-agregar').on('click', function() {
                var nuevaPregunta = $('.pregunta:first').clone();
                nuevaPregunta.find('input').val('');
                numPreguntas++;
                nuevaPregunta.find('.num-pregunta').text(numPreguntas);
                nuevaPregunta.find('.btn-eliminar').on('click', function() {
                    if (numPreguntas > 1) {
                        $(this).closest('.pregunta').remove();
                        numPreguntas--;
                        actualizarNumerosPreguntas();
                    }
                });
                nuevaPregunta.appendTo('#contenedorPreguntas');
            });

            function actualizarNumerosPreguntas() {
                $('.pregunta').each(function(index) {
                    $(this).find('.num-pregunta').text(index + 1);
                });
            }


            $('#btn-guardar-test').on('click', function() {

                var courseId = {{ $course->id }};
                // Obtener la fecha y hora del test
                var fechaTest = $('#formGroupExampleInput').val();
                var horaTest = $('#tiempoResolucion').val();

                // Crear un array para almacenar las preguntas
                var preguntas = [];
                $('.pregunta').each(function() {
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
                    url: '/admin/evaluations/store/' + courseId,
                    method: 'POST',
                    data: datosTest,
                    success: function(response) {
                        window.location.href = '{{ route("voyager.tests.index") }}';
                    },
                    error: function(error) {
                        console.error(error);
                    }
                });
            });


        });
    </script>
@endsection

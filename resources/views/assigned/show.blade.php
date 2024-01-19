@extends('voyager::master')

@section('content')

    <!-- Agrega esta referencia a jQuery en la sección head de tu HTML, antes de tu script -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    @auth

        @if ($user->role && $user->role->name == 'admin' || $user->role && $user->role->name == 'docente')
            <div class="container text-start">
                <div class="row">
                    <div class="col-md-6">

                        <!-- Información del Curso -->
                        <div class="card">
                            <div class="card-body">
                                <h3>{{ $course->name }}</h3>
                                <p>{{ $course->description }}</p>

                                <p>Esta clase está dictada por:</p>
                                <ul>
                                    @forelse ($teacherNames as $teacherName)
                                        <li><strong>{{ $teacherName }}</strong></li>
                                    @empty
                                        <li><strong>No hay profesores asignados a esta clase.</strong></li>
                                    @endforelse
                                </ul>
                            </div>
                        </div>

                        <!-- Lista de Estudiantes Matriculados -->
                        <div class="card mt-4">
                            <div class="card-body">
                                <h4>Estudiantes matriculados</h4>
                                @if (count($studentNames) > 0)
                                    <ul>
                                        @foreach ($studentNames as $studentName)
                                            <li>{{ $studentName }}</li>
                                        @endforeach
                                    </ul>
                                @else
                                    <p>No hay estudiantes matriculados en esta clase.</p>
                                @endif
                            </div>
                        </div>

                    </div>

                    <!-- Sección de Planificación (Agregada a la derecha) -->
                    <div class="col-md-6">

                        <div class="card">
                            <div class="card-body">
                                <h4>Planificación del Curso</h4>
                                <a href="{{ route('assigned.add', ['id' => $course->id]) }}" class="btn btn-info">Agregar
                                    planificación</a>
                                <br>

                                @if ($course->planifications)
                                    @foreach ($course->planifications as $planification)
                                        <div style="display: inline-block; vertical-align: middle; margin-bottom: 10px;">
                                            <p style="display: inline-block; margin-right: 10px; vertical-align: middle;">
                                                {{ $planification->name }}</p>
                                            <a href="#" class="btn btn-primary btn-detalles"
                                                data-name="{{ $planification->name }}" data-file="{{ $planification->file }}"
                                                style="display: inline-block; vertical-align: middle;">Detalles</a>
                                        </div>
                                    @endforeach
                                @else
                                    <h3>Aun no se ha agregado planificación a este curso</h3>
                                @endif
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <!--FIN DEL ROL ADMIN-->
        @elseif ($user->role && $user->role->name == 'alumno')


        <div class="container text-start">
            <div class="row">
                <div class="col-md-6">

                    <!-- Información del Curso -->
                    <div class="card">
                        <div class="card-body">
                            <h3>{{ $course->name }}</h3>
                            <p>{{ $course->description }}</p>

                            <p>Esta clase está dictada por:</p>
                            <ul>
                                @forelse ($teacherNames as $teacherName)
                                    <li><strong>{{ $teacherName }}</strong></li>
                                @empty
                                    <li><strong>No hay profesores asignados a esta clase.</strong></li>
                                @endforelse
                            </ul>
                        </div>
                    </div>

                </div>

                <!-- Sección de Planificación (Agregada a la derecha) -->
                <div class="col-md-6">

                    <div class="card">
                        <div class="card-body">
                            <h4>Planificación del Curso</h4>

                            @if ($course->planifications)
                                @foreach ($course->planifications as $planification)
                                    <div style="display: inline-block; vertical-align: middle; margin-bottom: 10px;">
                                        <p style="display: inline-block; margin-right: 10px; vertical-align: middle;">
                                            {{ $planification->name }}</p>
                                        <a href="#" class="btn btn-primary btn-detalles"
                                            data-name="{{ $planification->name }}" data-file="{{ $planification->file }}"
                                            style="display: inline-block; vertical-align: middle;">Detalles</a>
                                    </div>
                                @endforeach
                            @else
                                <h3>Aun no se ha agregado planificación a este curso</h3>
                            @endif
                        </div>
                    </div>

                </div>
            </div>
        </div>




        @endif

        <!-- Agrega este modal al final de tu HTML, después del cierre del tag </body> -->
        <div class="modal" id="detallesModal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Detalles de la Planificación</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- Contenido del modal, puedes personalizarlo según tus necesidades -->
                        <p>Aquí puedes agregar más detalles sobre la planificación seleccionada.</p>
                    </div>

                </div>
            </div>
        </div>

    @endauth

    <!-- Agrega este script al final de tu HTML, antes del cierre del tag </body> -->
    <script>
        // Espera a que el documento esté completamente cargado
        jQuery(document).ready(function() {
            // Asigna un evento de clic al botón "Detalles"
            jQuery('.btn-detalles').on('click', function() {
                // Recupera los datos de la planificación seleccionada
                var planificationName = jQuery(this).data('name');
                var planificationFile = jQuery(this).data('file');

                // Muestra la información en el modal
                jQuery('#detallesModal .modal-title').text('Detalles de ' + planificationName);
                jQuery('#detallesModal .modal-body').html('<p>Nombre: ' + planificationName + '</p>');

                // Agrega la información del archivo al modal
                if (planificationFile) {
                    jQuery('#detallesModal .modal-body').append('<p>Archivo: <a href="' +
                        planificationFile + '" target="_blank">' + planificationFile + '</a></p>');
                }

                // Muestra el modal correspondiente
                jQuery('#detallesModal').modal('show');
            });
        });
    </script>


@endsection

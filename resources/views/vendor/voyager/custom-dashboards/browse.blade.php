@extends('voyager::master')

@section('content')
    <div class="page-content">
        @include('voyager::alerts')
        @include('voyager::dimmers')
        <div class="analytics-container">
            <div class="card">
                <div class="card-body">
                    <?php $user = auth()->user(); ?>

                    @php
                         $tests = [];
                    @endphp


                    @if ($user)

                        @if ($user->role && $user->role->name == 'admin')

                            @php
                                // Consulta la tabla "companies" para obtener la información
                                $companyInfo = \App\Company::select('info')->first();

                                $allTests = \App\Models\Test::all();

                                $tests = [];

                                foreach ($allTests as $test) {
                                    $startDateTime = date('Y-m-d', strtotime($test->date)) . ' 08:00:00';
                                    $endDateTime = date('Y-m-d', strtotime($test->date)) . ' 23:59:00';
                                    $tests[] = [
                                        'title' => $test->course->name, // a property!
                                        'start' => $startDateTime,
                                        'end' => $endDateTime,
                                    ];
                                }

                                //dd($tests);

                            @endphp

                            @if (!$companyInfo)
                                <div class="container">
                                    <div class="row justify-content-center">
                                        <div class="col-md-6">
                                            <div class="card">
                                                <div class="card-body">
                                                    <h5 class="card-title">Hey! {{ $user->name }}</h5>
                                                    <h6 class="card-subtitle mb-2 text-body-secondary">No tenemos
                                                        información de tu empresa</h6>
                                                    <p class="card-text">Si deseas agregar información de tu empresa,
                                                        selecciona <strong>Agregar</strong>.</p>
                                                    <a href="/admin/companies/create" class="btn btn-primary">Agregar</a>
                                                    <a href="#" class="btn btn-secondary">Skip</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                @if ($companyInfo->info)
                                    @php
                                        $infoArray = json_decode($companyInfo->info, true);
                                    @endphp
                                    <h1>{{ $infoArray['nombre'] }}</h1>
                                    <p>RUC: {{ $infoArray['ruc'] }}</p>
                                    <p>Teléfono: {{ $infoArray['telefono'] }}</p>
                                    <p>Dirección: {{ $infoArray['direccion'] }}</p>
                                    <p>Razón Social: {{ $infoArray['razon_social'] }}</p>
                                @endif

                                <h4>Los proximos examenes a realizar</h4>
                                <div id='calendar'></div>
                            @endif
                            <!--Hasta aqui el rol Admin -->
                        @elseif ($user->role && $user->role->name == 'docente')
                            @php
                                $user = auth()->user();
                            @endphp

                            @if ($user->hasTeacher())
                                <p>Hola, {{ $user->name }}</p>

                                {{-- Decodificar el campo info --}}
                                @php
                                    $teacherInfo = json_decode($user->teacher->info, true);

                                    $testsWithoutResponse = \App\Models\test::whereDoesntHave('responses', function ($query) use ($user) {
                                        $query->where('id_student', $user->id);
                                    })->get();

                                    $tests = [];

                                    foreach ($testsWithoutResponse as $test) {
                                        $startDateTime = date('Y-m-d', strtotime($test->date)) . ' 08:00:00';
                                        $endtDateTime = date('Y-m-d', strtotime($test->date)) . ' 23:59:00';
                                        $tests[] = [
                                            'title' => $test->course->name, // a property!
                                            'start' => $startDateTime,
                                            'end' => $endtDateTime,
                                        ];
                                    }

                                @endphp

                                {{-- Verificar si la decodificación fue exitosa --}}
                                @if ($teacherInfo)
                                    {{-- Mostrar la información del estudiante --}}
                                    <ul>
                                        @foreach ($teacherInfo as $key => $value)
                                            {{-- Mostrar información específica para 'ci', 'tel' y 'fecha_na' --}}
                                            @if ($key == 'ci')
                                                <li>Cedula: {{ $value }}</li>
                                            @elseif ($key == 'tel')
                                                <li>Telefono: {{ $value }}</li>
                                            @elseif ($key == 'fecha_na')
                                                <li>Fecha de Nacimiento: {{ $value }}</li>
                                            @else
                                                <li>{{ $key }}: {{ $value }}</li>
                                            @endif
                                        @endforeach

                                    </ul>

                                    <h4>Tus proximos examenes</h4>
                                    <div id='calendar'></div>
                                @else
                                    <p>Error al decodificar la información del docente</p>
                                @endif
                            @else
                                <div class="container">
                                    <div class="row justify-content-center">
                                        <div class="col-md-6">
                                            <div class="card">
                                                <div class="card-body">
                                                    <h5 class="card-title">Hey! {{ $user->name }}</h5>
                                                    <h6 class="card-subtitle mb-2 text-body-secondary">No tenemos
                                                        información tu información</h6>
                                                    <p class="card-text">Si deseas agregar tu información,
                                                        selecciona <strong>Agregar</strong>.</p>
                                                    <a href="/admin/teachers/create" class="btn btn-primary">Agregar</a>
                                                    <a href="#" class="btn btn-secondary">Skip</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>



                            @endif

                            <!--Hasta aqui el rol docente-->
                        @elseif ($user->role && $user->role->name == 'alumno')
                            @php
                                $user = auth()->user();
                            @endphp

                            @if ($user->hasStudent())
                                <p>Hola, {{ $user->name }}</p>

                                {{-- Decodificar el campo info --}}
                                @php
                                    $studentInfo = json_decode($user->student->info, true);

                                    $testsWithoutResponse = \App\Models\test::whereDoesntHave('responses', function ($query) use ($user) {
                                        $query->where('id_student', $user->id);
                                    })->get();



                                    foreach ($testsWithoutResponse as $test) {
                                        $startDateTime = date('Y-m-d', strtotime($test->date)) . ' 08:00:00';
                                        $endtDateTime = date('Y-m-d', strtotime($test->date)) . ' 23:59:00';
                                        $tests[] = [
                                            'title' => $test->course->name, // a property!
                                            'start' => $startDateTime,
                                            'end' => $endtDateTime,
                                        ];
                                    }

                                @endphp

                                {{-- Verificar si la decodificación fue exitosa --}}
                                @if ($studentInfo)
                                    {{-- Mostrar la información del estudiante --}}
                                    <ul>
                                        @foreach ($studentInfo as $key => $value)
                                            {{-- Mostrar información específica para 'ci', 'tel' y 'fecha_na' --}}
                                            @if ($key == 'ci')
                                                <li>Cedula: {{ $value }}</li>
                                            @elseif ($key == 'tel')
                                                <li>Telefono: {{ $value }}</li>
                                            @elseif ($key == 'fecha_na')
                                                <li>Fecha de Nacimiento: {{ $value }}</li>
                                            @else
                                                <li>{{ $key }}: {{ $value }}</li>
                                            @endif
                                        @endforeach

                                    </ul>
                                @else
                                    <p>Error al decodificar la información del estudiante</p>
                                @endif
                            @else
                                <div class="container">
                                    <div class="row justify-content-center">
                                        <div class="col-md-6">
                                            <div class="card">
                                                <div class="card-body">
                                                    <h5 class="card-title">Hey! {{ $user->name }}</h5>
                                                    <h6 class="card-subtitle mb-2 text-body-secondary">No tenemos
                                                        tu información</h6>
                                                    <p class="card-text">Si deseas agregar tu información,
                                                        selecciona <strong>Agregar</strong>.</p>
                                                    <a href="/admin/students/create" class="btn btn-primary">Agregar</a>
                                                    <a href="#" class="btn btn-secondary">Skip</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            @endif
                            <h4>Tus proximos examenes</h4>
                            <div id='calendar'></div>
                            <!--Hasta aqui el rol alumno-->
                        @else
                            <!--Validacion para usuarios sin rol-->
                            <div class="container">
                                <div class="row justify-content-center">
                                    <div class="col-md-6">
                                        <div class="card">
                                            <div class="card-body">
                                                <h5 class="card-title">Hey! {{ $user->name }}</h5>
                                                <h6 class="card-subtitle mb-2 text-body-secondary">No tienes un rol asignado
                                                </h6>
                                                <p class="card-text"> Contacta con tu administrador de sistemas</p>
                                                <a href="#" class="btn btn-primary">Contact</a>
                                                <a href="#" class="btn btn-secondary">Skip</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                    @endif
                    <!--Fin validador usuario-->
                </div>
            </div>
        </div>
    </div>
@stop

@section('javascript')

    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js'></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            try {
                const calendarEl = document.getElementById('calendar');
                const calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'dayGridWeek',
                    events: @json($tests)
                });
                calendar.render();
            } catch (error) {
                console.error('Error al inicializar el calendario:', error);
            }
        });



        document.addEventListener("DOMContentLoaded", function() {
            // Obtén la referencia al enlace "Skip"
            var skipLink = document.querySelector('.btn-secondary');

            // Obtén la referencia a la sección que deseas ocultar
            var cardSection = document.querySelector('.card');

            // Agrega un evento de clic al enlace "Skip"
            skipLink.addEventListener('click', function(event) {
                // Previene el comportamiento predeterminado del enlace
                event.preventDefault();

                // Oculta la sección de la tarjeta
                cardSection.style.display = 'none';
            });
        });
    </script>


@stop

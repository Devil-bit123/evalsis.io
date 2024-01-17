@extends('voyager::master')

@section('content')
    <div class="page-content">
        @include('voyager::alerts')
        @include('voyager::dimmers')
        <div class="analytics-container">
            <div class="card">
                <div class="card-body">
                    <?php $user = auth()->user(); ?>

                    @if ($user)

                        @if ($user->role && $user->role->name == 'admin')

                            @php
                                // Consulta la tabla "companies" para obtener la información
                                $companyInfo = \App\Company::select('info')->first();
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
                            @endif
                            <!--Hasta aqui el rol Admin -->
                        @elseif ($user->role && $user->role->name == 'docente')
                            @php
                                // Consulta la tabla "teachers" para obtener la información
                                $teacherInfo = App\Teacher::where('idTeacher', '=', $user->id)->first();
                                //dd($teacherInfo);
                            @endphp

                            @if (!$teacherInfo)
                                <div class="container">
                                    <div class="row justify-content-center">
                                        <div class="col-md-6">
                                            <div class="card">
                                                <div class="card-body">
                                                    <h5 class="card-title">Hey! {{ $user->name }}</h5>
                                                    <h6 class="card-subtitle mb-2 text-body-secondary">No tenemos tu
                                                        información</h6>
                                                    <p class="card-text">Si deseas agregar tu información, selecciona
                                                        <strong>Agregar</strong>.
                                                    </p>
                                                    <a href="/admin/teachers/create" class="btn btn-primary">Agregar</a>
                                                    <a href="#" class="btn btn-secondary">Skip</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                @if ($teacherInfo->info)
                                    <h3>Hola, {{ $user->name }}</h3>
                                    @php
                                        $infoArray = json_decode($teacherInfo->info, true);
                                    @endphp
                                    <p>Teléfono {{ $infoArray['tel'] }}</p>
                                    <p>Cédula: {{ $infoArray['ci'] }}</p>
                                    <p>Fecha de nacimiento: {{ $infoArray['fecha_na'] }}</p>
                                @endif

                            @endif

                            <!--Hasta aqui el rol docente-->
                        @elseif ($user->role && $user->role->name == 'alumno')
                            @php
                                // Consulta la tabla "students" para obtener la información
                                $studentInfo = \App\Student::where('idStudent', '=', $user->id)->first();
                                //dd($teacherInfo);
                            @endphp

                            @if (!$studentInfo)
                                <div class="container">
                                    <div class="row justify-content-center">
                                        <div class="col-md-6">
                                            <div class="card">
                                                <div class="card-body">
                                                    <h5 class="card-title">Hey! {{ $user->name }}</h5>
                                                    <h6 class="card-subtitle mb-2 text-body-secondary">No tenemos tu
                                                        información</h6>
                                                    <p class="card-text">Si deseas agregar tu información, selecciona
                                                        <strong>Agregar</strong>.
                                                    </p>
                                                    <a href="/admin/students/create" class="btn btn-primary">Agregar</a>
                                                    <a href="#" class="btn btn-secondary">Skip</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else

                            @if ($studentInfo->info)
                                    <h3>Hola, {{ $user->name }}</h3>
                                    @php
                                        $infoArray = json_decode($studentInfo->info, true);
                                    @endphp
                                    <p>Teléfono {{ $infoArray['tel'] }}</p>
                                    <p>Cédula: {{ $infoArray['ci'] }}</p>
                                    <p>Fecha de nacimiento: {{ $infoArray['fecha_na'] }}</p>
                                @endif



                            @endif

                        @endif
                    @endif
                    <!--Hasta aqui el rol alumno-->
                </div>
            </div>
        </div>
    </div>
@stop

@section('javascript')

    <script>
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

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
                        <p>Bienvenido, {{ $user->name }}

                            @if ($user->role && $user->role->name == 'admin')

                                @php
                                // Consulta la tabla "companies" para obtener la información
                                $companyInfo = \App\Models\Company::select('info')->first();
                                @endphp

                                @if (!$companyInfo)
                                <div class="container">
                                    <div class="row justify-content-center">
                                        <div class="col-md-6">
                                            <div class="card">
                                                <div class="card-body">
                                                    <h5 class="card-title">Hey!</h5>
                                                    <h6 class="card-subtitle mb-2 text-body-secondary">No tenemos información de tu empresa</h6>
                                                    <p class="card-text">Si deseas agregar información de tu empresa, selecciona <strong>Agregar</strong>.</p>
                                                    <a href="/admin/companies/create" class="btn btn-primary">Agregar</a>
                                                    <a href="#" class="btn btn-secondary">Skip</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                @else
                                <p>Si hay info</p>
                                @endif

                            @elseif ($user->role && $user->role->name == 'docente')
                                (Docente)


                            @elseif ($user->role && $user->role->name == 'alumno')
                                (Alumno)
                            @endif

                        </p>
                    @endif
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

@extends('layouts.app')

@section('content')
<div class="container">

    @if (!$usuario->hasRole(['admin', 'docente', 'alumno']))
    @php
            $redirectPath = '/admin';
    @endphp

<script>window.location = "{{ $redirectPath }}";</script>

    @else
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Hey!') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('Te has registrado con exito, contacta con el administrador de sistemas para asignarte un rol') }}
                </div>
            </div>
        </div>
    </div>

    @endif




</div>
@endsection

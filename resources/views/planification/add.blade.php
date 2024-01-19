@extends('voyager::master')

@section('content')
<div class="card">

    @auth

    @if ($user->role && $user->role->name == 'admin' || $user->role && $user->role->name == 'docente')

    @endif

    <div class="card-body">
        <h3>{{ $course->name }}</h3>
    </div>
    <p>Ingresa tu planificación al sistema</p>

    <div class="box box-info padding-1">
        <div class="box-body">

            {{ Form::open(['url' => route('assigned.store', ['id' => $course->id]), 'method' => 'post', 'enctype' => 'multipart/form-data']) }}

            <div class="form-group">
                {{ Form::label('Nombre de la planificacion') }}
                {{ Form::text('name', old('name', $planification->name ?? ''), ['class' => 'form-control' . ($errors->has('name') ? ' is-invalid' : ''), 'placeholder' => 'Nombre']) }}
                {!! $errors->first('name', '<div class="invalid-feedback">:message</div>') !!}
            </div>

            <div class="form-group">
                {{ Form::label('Descripcion de la planificacion') }}
                {{ Form::text('description', old('description', $planification->description ?? ''), ['class' => 'form-control' . ($errors->has('description') ? ' is-invalid' : ''), 'placeholder' => 'Descripción']) }}
                {!! $errors->first('description', '<div class="invalid-feedback">:message</div>') !!}
            </div>

            <div class="form-group">
                {{ Form::label('Archivo de la planificación') }}
                {{ Form::file('file', ['class' => 'form-control-file' . ($errors->has('file') ? ' is-invalid' : '')]) }}
                {!! $errors->first('file', '<div class="invalid-feedback">:message</div>') !!}
            </div>

            {{ Form::submit('Guardar', ['class' => 'btn btn-primary']) }}

        {{ Form::close() }}

        </div>

    </div>




  </div>


    @endauth



@stop

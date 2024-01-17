<div class="box box-info padding-1">
    <div class="box-body">

        <div class="form-group">
            {{ Form::label('Nombre') }}
            {{ Form::text('info[nombre]', $company->info['nombre'] ?? '', ['class' => 'form-control' . ($errors->has('info.nombre') ? ' is-invalid' : ''), 'placeholder' => 'Nombre']) }}
            {!! $errors->first('info.nombre', '<div class="invalid-feedback">:message</div>') !!}
        </div>

        <div class="form-group">
            {{ Form::label('Razon Social') }}
            {{ Form::text('info[razon_social]', $company->info['razon_social'] ?? '', ['class' => 'form-control' . ($errors->has('info.razon_social') ? ' is-invalid' : ''), 'placeholder' => 'Razón Social']) }}
            {!! $errors->first('info.razon_social', '<div class="invalid-feedback">:message</div>') !!}
        </div>

        <div class="form-group">
            {{ Form::label('Dirección') }}
            {{ Form::text('info[direccion]', $company->info['direccion'] ?? '', ['class' => 'form-control' . ($errors->has('info.direccion') ? ' is-invalid' : ''), 'placeholder' => 'Dirección']) }}
            {!! $errors->first('info.direccion', '<div class="invalid-feedback">:message</div>') !!}
        </div>

        <div class="form-group">
            {{ Form::label('Ruc') }}
            {{ Form::text('info[ruc]', $company->info['ruc'] ?? '', ['class' => 'form-control' . ($errors->has('info.ruc') ? ' is-invalid' : ''), 'placeholder' => 'RUC']) }}
            {!! $errors->first('info.ruc', '<div class="invalid-feedback">:message</div>') !!}
        </div>

        <div class="form-group">
            {{ Form::label('Telefono') }}
            {{ Form::text('info[telefono]', $company->info['telefono'] ?? '', ['class' => 'form-control' . ($errors->has('info.telefono') ? ' is-invalid' : ''), 'placeholder' => 'Telefono']) }}
            {!! $errors->first('info.telefono', '<div class="invalid-feedback">:message</div>') !!}
        </div>

    </div>
    <div class="box-footer mt20">
        <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
    </div>
</div>

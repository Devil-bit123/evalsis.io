<div class="box box-info padding-1">
    <div class="box-body">
        
        <div class="form-group">
            {{ Form::label('idTeacher') }}
            {{ Form::text('idTeacher', $teacher->idTeacher, ['class' => 'form-control' . ($errors->has('idTeacher') ? ' is-invalid' : ''), 'placeholder' => 'Idteacher']) }}
            {!! $errors->first('idTeacher', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('info') }}
            {{ Form::text('info', $teacher->info, ['class' => 'form-control' . ($errors->has('info') ? ' is-invalid' : ''), 'placeholder' => 'Info']) }}
            {!! $errors->first('info', '<div class="invalid-feedback">:message</div>') !!}
        </div>

    </div>
    <div class="box-footer mt20">
        <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
    </div>
</div>
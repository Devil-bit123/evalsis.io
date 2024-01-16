<div class="box box-info padding-1">
    <div class="box-body">
        
        <div class="form-group">
            {{ Form::label('info') }}
            {{ Form::text('info', $company->info, ['class' => 'form-control' . ($errors->has('info') ? ' is-invalid' : ''), 'placeholder' => 'Info']) }}
            {!! $errors->first('info', '<div class="invalid-feedback">:message</div>') !!}
        </div>

    </div>
    <div class="box-footer mt20">
        <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
    </div>
</div>
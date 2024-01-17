<div class="box box-info padding-1">
    <div class="box-body">

        <div class="form-group">
            {{ Form::label('Cédula') }}
            {{ Form::text('info[ci]', $company->info['ci'] ?? '', ['class' => 'form-control' . ($errors->has('info.ci') ? ' is-invalid' : ''), 'placeholder' => 'Cédula']) }}
            {!! $errors->first('info.ci', '<div class="invalid-feedback">:message</div>') !!}
        </div>

        <div class="form-group">
            {{ Form::label('Fecha de Nacimiento') }}
            {{ Form::date('info[fecha_na]', $company->info['fecha_na'] ?? '', ['class' => 'form-control' . ($errors->has('info.fecha_na') ? ' is-invalid' : ''), 'placeholder' => 'Fecha de Nacimiento', 'id' => 'info_fecha_na']) }}
            {!! $errors->first('info.fecha_na', '<div class="invalid-feedback">:message</div>') !!}
        </div>

        <div class="form-group">
            {{ Form::label('telefono') }}
            {{ Form::text('info[tel]', $company->info['tel'] ?? '', ['class' => 'form-control' . ($errors->has('info.tel') ? ' is-invalid' : ''), 'placeholder' => 'Telefono']) }}
            {!! $errors->first('info.tel', '<div class="invalid-feedback">:message</div>') !!}
        </div>

    </div>
    <div class="box-footer mt20">
        <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
    </div>
</div>




<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Obtener el campo de fecha de nacimiento
        var fechaNaInput = document.getElementById('info_fecha_na');

        // Agregar un evento de cambio al campo de fecha de nacimiento
        fechaNaInput.addEventListener('input', function () {
            // Obtener la fecha de nacimiento introducida por el usuario
            var fechaNa = new Date(fechaNaInput.value);
            var fechaNaYear = fechaNa.getFullYear();
            var fechaNaMonth = fechaNa.getMonth();
            var fechaNaDay = fechaNa.getDate();

            // Calcular la fecha actual
            var fechaActual = new Date();
            var fechaActualYear = fechaActual.getFullYear();
            var fechaActualMonth = fechaActual.getMonth();
            var fechaActualDay = fechaActual.getDate();

            // Restar 20 años a la fecha actual
            var limiteFecha = new Date();
            limiteFecha.setFullYear(fechaActualYear - 20, fechaActualMonth, fechaActualDay);

            // Comparar las fechas
            if (fechaNa > limiteFecha) {
                alert('Tu fecha de nacimiento no es valida.');
                fechaNaInput.value = ''; // Limpiar el campo si la fecha no es válida
            }
        });
    });
</script>

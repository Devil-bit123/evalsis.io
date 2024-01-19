@extends('voyager::master')

@section('content')
<div class="card">
    <div class="card-header">
        <h3>Hola, {{ $user->name }}</h3>
    </div>
    <div class="card-body">
        <h5 class="card-title">Por favor selecciona el curso al que deseas dar de baja al docente</h5>
        <form id="deleteForm" action="{{ route('matriculation.delete', ['course_id' => $courses->first()->id, 'id' => $user->id]) }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="curso">Cursos:</label>
                <select name="curso" id="curso" class="form-control">
                    @foreach($courses as $course)
                        <option value="{{ $course->id }}">{{ $course->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="docente">Docentes:</label>
                <select name="docente" id="docente" class="form-control">
                    <!-- Opciones de docentes se cargarán dinámicamente aquí -->
                </select>
            </div>

            <button type="button" class="btn btn-danger" onclick="confirmDelete()">Dar de baja</button>
        </form>
    </div>
</div>

<script>
    function confirmDelete() {
        var docenteDropdown = document.getElementById('docente');
        var selectedDocenteOption = docenteDropdown.options[docenteDropdown.selectedIndex];

        var docenteId = selectedDocenteOption.getAttribute('data-docente-id');
        var confirmResult = confirm("¿Estás seguro de que deseas dar de baja al docente con ID " + docenteId + "?");

        if (confirmResult) {
            // Agrega el ID del docente como un campo oculto antes de enviar el formulario
            var hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = 'docente_id';
            hiddenInput.value = docenteId;

            document.getElementById('deleteForm').appendChild(hiddenInput);

            // Si el usuario hace clic en "Aceptar", envía el formulario
            document.getElementById('deleteForm').submit();
        } else {
            // Si el usuario hace clic en "Cancelar", no hagas nada
        }
    }

    document.getElementById('curso').addEventListener('change', function () {
        var cursoId = this.value;

        // Realiza una solicitud Ajax para obtener la lista de docentes
        $.ajax({
            type: 'GET',
            url: 'take-teacher/' + cursoId,
            success: function (data) {
                // Actualiza el dropdown de docentes con la nueva lista
                var docenteDropdown = document.getElementById('docente');
                docenteDropdown.innerHTML = ''; // Limpia el dropdown actual

                // Agrega las nuevas opciones al dropdown
                data.forEach(function (teacher) {
                    var option = document.createElement('option');
                    option.value = teacher.id;
                    option.text = teacher.name;
                    option.setAttribute('data-docente-id', teacher.id); // Agrega el ID como atributo de datos
                    docenteDropdown.add(option);
                });
            }
        });
    });
</script>

@stop

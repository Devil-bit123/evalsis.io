@extends('voyager::master')

@section('template_title')
    {{ $student->name ?? "{{ __('Show') Student" }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <span class="card-title">{{ __('Show') }} Student</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary" href="{{ route('students.index') }}"> {{ __('Back') }}</a>
                        </div>
                    </div>

                    <div class="card-body">

                        <div class="form-group">
                            <strong>Idstudent:</strong>
                            {{ $student->idStudent }}
                        </div>
                        <div class="form-group">
                            <strong>Info:</strong>
                            {{ $student->info }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@extends('layouts.app')

@section('template_title')
    {{ $teacher->name ?? "{{ __('Show') Teacher" }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <span class="card-title">{{ __('Show') }} Teacher</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary" href="{{ route('teachers.index') }}"> {{ __('Back') }}</a>
                        </div>
                    </div>

                    <div class="card-body">
                        
                        <div class="form-group">
                            <strong>Idteacher:</strong>
                            {{ $teacher->idTeacher }}
                        </div>
                        <div class="form-group">
                            <strong>Info:</strong>
                            {{ $teacher->info }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@extends('voyager::master')

@section('template_title')
    {{ __('Update') }} Company
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="">
            <div class="col-md-12">

                @includeif('partials.errors')

                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title">{{ __('Update') }} Company</span>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('companies.update', $company->id) }}"  role="form" enctype="multipart/form-data">
                            {{ method_field('PATCH') }}
                            @csrf

                            @include('company.form')

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

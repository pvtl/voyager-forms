@extends('voyager::master')

@section('page_title', "Viewing $dataType->display_name_plural")

@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@stop

@section('page_header')
    <h1 class="page-title">
        <i class="{{ $dataType->icon }}"></i>
        {{ "Viewing $dataType->display_name_plural" }}
    </h1>
@stop

@section('content')
    <div class="page-content container-fluid">
        @include('voyager::alerts')
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-bordered">
                    @if (!$forms || count($forms) === 0)
                        No forms found, try adding one.
                    @endif

                    @foreach ($forms as $form)
                        This will print out our forms.
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@stop

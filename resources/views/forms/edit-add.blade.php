@extends('voyager::master')

@section('page_title', __('voyager.generic.'.(isset($dataTypeContent->id) ? 'edit' : 'add')).' '.$dataType->display_name_singular)

@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@stop

@section('page_header')
    <h1 class="page-title">
        <i class="{{ $dataType->icon }}"></i>
        {{ __('voyager.generic.'.(isset($dataTypeContent->id) ? 'edit' : 'add')).' '.$dataType->display_name_singular }}
    </h1>
@stop

@section('content')
    <div class="page-content container-fluid">
        @include('voyager::alerts')
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-bordered">
                    <form
                        class="form-edit-add"
                        role="form"
                        action="@if (isset($dataTypeContent->id))
                        {{ route('voyager.'.$dataType->slug.'.update', $dataTypeContent->id) }}
                        @else
                        {{ route('voyager.'.$dataType->slug.'.store') }}
                        @endif"
                        method="POST"
                        enctype="multipart/form-data">

                    </form>
                </div>
            </div>
        </div>
    </div>
@stop

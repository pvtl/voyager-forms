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

            {{ csrf_field() }}

            @if(isset($dataTypeContent->id))
                {{ method_field("PUT") }}
            @endif

            <div class="row">
                <div class="col-md-8">
                    <!-- ### TITLE ### -->
                    <div class="panel panel-body">
                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <label for="title">Title</label><br>
                        <input name="title" class="form-control" type="text" required>

                        <label for="view">View</label><br>
                        <input name="view" class="form-control" type="text">

                        <label for="mailto">Mail To (Separate multiple with ',')</label><br>
                        <input name="mailto" class="form-control" type="text" required>

                        <label for="hook">Event Hook (Fires after form is submitted)</label><br>
                        <input name="hook" class="form-control" type="text">
                    </div>

                    <div class="panel-footer">
                        <button type="submit" class="btn btn-primary">{{ __('voyager.generic.submit') }}</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@stop

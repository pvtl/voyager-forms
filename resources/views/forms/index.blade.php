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

                    <div class="table-responsive">
                        <table id="dataTable" class="table table-hover">
                            <thead>
                            <tr>
                                <td>ID</td>
                                <td>Title</td>
                                <td>View</td>
                                <td>Mail To</td>
                                <td>Hook</td>
                                <td>Created At</td>
                                <td>Updated At</td>
                            </tr>
                            </thead>

                            @foreach ($forms as $form)
                                <tr>
                                    <td>{{ $form->id }}</td>
                                    <td>{{ $form->title }}</td>
                                    <td>{{ $form->view }}</td>
                                    <td>{{ $form->mailto }}</td>
                                    <td>{{ $form->hook }}</td>
                                    <td>{{ $form->created_at }}</td>
                                    <td>{{ $form->updated_at }}</td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

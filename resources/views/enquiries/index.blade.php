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
                    @if (!$enquiries || count($enquiries) === 0)
                        No enquiries found, try adding one.
                    @endif

                    @foreach ($enquiries as $enquiry)
                        This will print out our enquiries.
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@stop

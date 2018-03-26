@extends('voyager::master')

@section('page_title', __('voyager.generic.viewing').' '.$dataType->display_name_plural)

@section('page_header')
    <div class="container-fluid">
        <h1 class="page-title">
            <i class="{{ $dataType->icon }}"></i> {{ $dataType->display_name_plural }}
        </h1>
        @include('voyager::multilingual.language-selector')
    </div>
@stop

@section('content')
    <div class="page-content browse container-fluid">
        @include('voyager::alerts')
        <div class="row">
            <div class="col-md-6">
                <div class="panel panel-bordered">
                    <div class="panel-body">
                        <h3 class="panel-title">Enquiry Data</h3>

                        <div class="panel-body">
                            <b>Form ID</b>
                            <p>{{ $enquiry->form_id }}</p>
                        </div>

                        <div class="panel-body">
                            <b>Mailed To</b>
                            <p>{{ $enquiry->mailed_to }}</p>
                        </div>

                        <div class="panel-body">
                            <b>IP Address</b>
                            <p>{{ $enquiry->ip_address }}</p>
                        </div>

                        <div class="panel-body">
                            <b>Submitted At</b>
                            <p>{{ $enquiry->created_at }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="panel panel-bordered">
                    <div class="panel-body">
                        <h3 class="panel-title">Submitted Data</h3>

                        @foreach ($enquiry->data as $key => $value)
                            @if (in_array($key, ['_token', 'id']))
                                @continue
                            @endif

                            <div class="panel-body">
                                <b>{{ str_replace('_', ' ', $key) }}</b>
                                <p>{{ $value }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop


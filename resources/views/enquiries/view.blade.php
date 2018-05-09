@extends('voyager::master')

@section('page_title', __('voyager::generic.viewing').' '.$dataType->display_name_plural)

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
            <div class="col-md-4">
                <div class="panel panel-bordered panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">Enquiry</h3>
                    </div> <!-- /.panel-heading -->

                    <table class="table">
                        <tr>
                            <th width="25%">Form ID</th>
                            <td>
                                <a href="{{ route('voyager.forms.edit', $enquiry->form_id) }}">
                                    {{ $enquiry->form_id }} (View)
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <th>Mailed To</th>
                            <td>{{ $enquiry->mailto }}</td>
                        </tr>
                        <tr>
                            <th>From IP Address</th>
                            <td>{{ $enquiry->ip_address }}</td>
                        </tr>
                        <tr>
                            <th>Submitted At</th>
                            <td>{{ $enquiry->created_at }}</td>
                        </tr>
                    </table>
                </div> <!-- /.panel -->
            </div> <!-- /.col -->

            <div class="col-md-8">
                <div class="panel panel-bordered">
                    <div class="panel-heading">
                        <h3 class="panel-title">Submitted Data</h3>
                    </div> <!-- /.panel-heading -->

                    <table class="table">
                        @foreach ($enquiry->data as $key => $value)
                            <tr>
                                <th width="25%">{{ str_replace('_', ' ', $key) }}</th>
                                <td>{!! nl2br($value) !!}</td>
                            </tr>
                        @endforeach
                    </table>
                </div> <!-- /.panel -->
            </div> <!-- /.col -->
        </div> <!-- /.row -->
    </div> <!-- /.page-content -->
@stop


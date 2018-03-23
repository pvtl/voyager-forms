@extends('voyager::master')

@section('page_title', __('voyager.generic.'.(isset($form->id) ? 'edit' : 'add')).' '.$dataType->display_name_singular)

@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@stop

@section('page_header')
    <h1 class="page-title">
        <i class="{{ $dataType->icon }}"></i>
        {{ __('voyager.generic.'.(isset($form->id) ? 'edit' : 'add')).' '.$dataType->display_name_singular }}
    </h1>
@stop

@section('content')
    <div class="page-content container-fluid">
        @include('voyager::alerts')
        <div class="row">

            @if (isset($form->id))
                <div class="col-md-3 col-lg-2">
                    <div class="panel panel-bordered panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title">Add Field</h3>
                            <div class="panel-actions">
                                <a class="panel-collapse-icon voyager-angle-down" data-toggle="block-collapse"
                                   aria-hidden="true"></a>
                            </div> <!-- /.panel-actions -->
                        </div> <!-- /.panel-heading -->

                        <div class="panel-body">
                            <form role="form" action="{{ route('voyager.inputs.store') }}" method="POST"
                                  enctype="multipart/form-data">
                                {{ csrf_field() }}

                                <div class="form-group">
                                    <label for="type">Field Type</label>
                                    <select class="form-control" name="input" id="input">
                                        <option value="">-- Select --</option>

                                        @foreach (config('voyager-forms.available_inputs') as $key => $value)
                                            <option value="{{ $key }}">{{ $value }}</option>
                                        @endforeach
                                    </select>
                                </div> <!-- /.form-group -->

                                <input type="hidden" name="form_id" value="{{ $form->id }}"/>
                                <button type="submit"
                                        class="btn btn-success btn-sm">{{ __('voyager.generic.add') }}</button>
                            </form>
                        </div> <!-- /.panel-body -->

                        <div class="panel panel-bordered panel-warning">
                            <div class="panel-heading">
                                <h3 class="panel-title">Form Layout</h3>
                                <div class="panel-actions">
                                    <a class="panel-collapse-icon voyager-angle-down" data-toggle="block-collapse"
                                       aria-hidden="true"></a>
                                </div> <!-- /.panel-actions -->
                            </div> <!-- /.panel-heading -->

                            <div class="panel-body">
                                <form role="form" action="{{ route('voyager.forms.layout', $form->id) }}" method="POST"
                                      enctype="multipart/form-data">
                                    {{ csrf_field() }}

                                    @php
                                        $formLayouts = $form->getLayouts();
                                    @endphp

                                    <div class="form-group">
                                        <label for="layout">Change Form Layout</label>
                                        <select class="form-control" name="layout" id="layout">
                                            <option value="default">-- Select --</option>
                                            @foreach($formLayouts as $layout)
                                                <option
                                                    value="{{ $layout }}"
                                                    @if ($form->layout === $layout)
                                                    selected="selected"
                                                    @endif
                                                >
                                                    {{ ucwords(str_replace(array('_', '-'), ' ', $layout)) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div> <!-- /.form-group -->

                                    <input type="hidden" name="page_id" value="{{ $form->id }}"/>
                                    <button type="submit"
                                            class="btn btn-success btn-sm">{{ __('voyager.generic.update') }}</button>
                                </form>
                            </div> <!-- /.panel-body -->
                        </div> <!-- /.panel -->

                    </div>
                </div>
            @endif

            <div class="col-md-9">
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

                    <form
                        role="form"
                        action="@if (isset($form->id))
                        {{ route('voyager.'.$dataType->slug.'.update', $form->id) }}
                        @else
                        {{ route('voyager.'.$dataType->slug.'.store') }}
                        @endif"
                        method="POST"
                        enctype="multipart/form-data">

                        {{ csrf_field() }}

                        @if (isset($form->id))
                            {{ method_field("PUT") }}
                        @endif
                        <label for="title">Title</label><br>
                        <input name="title" class="form-control" type="text"
                               @if (isset($form->title)) value="{{ $form->title }}" @endif required>

                        <label for="view">View</label><br>
                        <input name="view" class="form-control" type="text"
                               @if (isset($form->view)) value="{{ $form->view }}" @endif>

                        <label for="mailto">Mail To (Separate multiple with ',')</label><br>
                        <input name="mailto" class="form-control" type="text"
                               @if (isset($form->mailto)) value="{{ $form->mailto }}" @endif required>

                        <label for="hook">Event Hook (Fires after form is submitted)</label><br>
                        <input name="hook" class="form-control" type="text"
                               @if (isset($form->hook)) value="{{ $form->hook }}" @endif>

                        <div class="panel-footer">
                            <button type="submit" class="btn btn-primary">{{ __('voyager.generic.submit') }}</button>
                        </div>
                    </form>

                    @if (isset($form))
                        @foreach ($form->inputs as $input)
                            <div class="panel-heading">
                                <h3 class="panel-title">{{ ucfirst($input->type) }} Input</h3>
                                <div class="panel-actions">
                                    <a class="panel-collapse-icon voyager-angle-down" data-toggle="block-collapse"
                                       aria-hidden="true"></a>
                                </div> <!-- /.panel-actions -->
                            </div> <!-- /.panel-heading -->

                            <div class="panel-body">
                                <form role="form" action="{{ route('voyager.inputs.update', $input->id) }}"
                                      method="POST"
                                      enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                    {{ method_field("PUT") }}

                                    <div class="form-group">
                                        <label for="label">Input Label</label>
                                        <input name="label" class="form-control" id="label" value="{{ $input->label }}">

                                        <label for="class">Input Class</label>
                                        <input name="class" class="form-control" id="class" value="{{ $input->class }}">

                                        <label for="required">Input Required</label>
                                        <input name="required" class="form-control" id="required"
                                               value="{{ $input->required }}">
                                    </div> <!-- /.form-group -->

                                    <input type="hidden" name="input_id" value="{{ $input->id }}"/>
                                    <button type="submit"
                                            class="btn btn-success btn-sm">{{ __('Update This Input') }}</button>
                                </form>
                            </div> <!-- /.panel-body -->
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
@stop

@extends('voyager::master')

@section('page_title', __('voyager.generic.'.(isset($form->id) ? 'edit' : 'add')).' '.$dataType->display_name_singular)

@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style type="text/css">
        /* Remove bottom margins */
        .row>[class*=col-].no-bottom-margin { margin-bottom: 0; }

        /* Toggle Button */
        .toggle.btn {
            box-shadow: 0 5px 9px -3px rgba(0,0,0,0.2);
            border: 1px solid rgba(0,0,0,0.2) !important;
        }

        /* Make Inputs a 'lil more visible */
        select,
        input[type="text"],
        .panel-body .select2-selection {
            border: 1px solid rgba(0,0,0,0.17)
        }
    </style>
@stop

@section('page_header')
    <h1 class="page-title">
        <i class="{{ $dataType->icon }}"></i>
        {{ __('voyager.generic.'.(isset($form->id) ? 'edit' : 'add')).' '.$dataType->display_name_singular }}
    </h1>
@stop

@section('content')
    <div class="page-content edit-add container-fluid">
        @include('voyager::alerts')

        <div class="row">
            @if (isset($form->id))

                <div class="col-md-4">
                    <div class="panel">
                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="panel-heading">
                            <h3 class="panel-title"><i class="voyager-info-circled"></i> Form Details</h3>
                        </div> <!-- /.panel-heading -->

                        <div class="panel-body">
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
                                <div class="form-group">
                                    <label for="title">Title</label><br>
                                    <input name="title" class="form-control" type="text"
                                           @if (isset($form->title)) value="{{ $form->title }}" @endif required>
                                </div>

                                <div class="form-group">
                                    <label for="mailto">Mail To <small>(Separate multiple with ',')</small></label><br>
                                    <input name="mailto" class="form-control" type="text"
                                           @if (isset($form->mailto)) value="{{ $form->mailto }}" @endif required>
                                </div>

                                <div class="form-group">
                                    <label for="hook">Event Hook <small>(Fires after form is submitted)</small></label><br>
                                    <input name="hook" class="form-control" type="text"
                                           @if (isset($form->hook)) value="{{ $form->hook }}" @endif>
                                </div>

                                <button type="submit"
                                        class="btn btn-primary">{{ __('voyager.generic.submit') }}</button>
                            </form>
                        </div>
                    </div>

                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title"><i class="voyager-window-list"></i> Form Layout</h3>
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

                    <div class="panel panel-bordered panel-warning">
                        <div class="panel-heading">
                            <h3 class="panel-title"><i class="voyager-plus"></i> Add Field</h3>
                        </div> <!-- /.panel-heading -->

                        <div class="panel-body">
                            <form role="form" action="{{ route('voyager.inputs.store') }}" method="POST"
                                  enctype="multipart/form-data">
                                {{ csrf_field() }}

                                <div class="form-group">
                                    <label for="type">Field Type</label>
                                    <select class="form-control" name="type" id="type">
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
                    </div>
                </div>
            @endif


            <div class="col-md-8">
                @if (isset($form))
                    @each('voyager-forms::inputs.edit-add', $form->inputs, 'input')
                @endif
            </div>
        </div>
    </div>
@stop

@section('javascript')
    <script>
        $('document').ready(function () {
            $('.toggleswitch').bootstrapToggle();

            /**
             * Confirm DELETE input
             */
            $("[data-delete-input-btn]").on('click', function (e) {
                e.preventDefault();
                var result = confirm("Are you sure you want to delete this input?");
                if (result) $(this).closest('form').submit();
            });
        });
    </script>
@stop

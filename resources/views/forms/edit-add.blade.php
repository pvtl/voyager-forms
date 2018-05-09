@extends('voyager::master')

@section('page_title', __('voyager::generic.'.(isset($form->id) ? 'edit' : 'add')).' '.$dataType->display_name_singular)

@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style type="text/css">
        /* Remove bottom margins */
        .row > [class*=col-].no-bottom-margin {
            margin-bottom: 0;
        }

        /* Toggle Button */
        .toggle.btn {
            box-shadow: 0 5px 9px -3px rgba(0, 0, 0, 0.2);
            border: 1px solid rgba(0, 0, 0, 0.2) !important;
        }

        /* Make Inputs a 'lil more visible */
        select,
        input[type="text"],
        .panel-body .select2-selection {
            border: 1px solid rgba(0, 0, 0, 0.17)
        }

        /* Reorder */
        .dd .dd-placeholder {
            max-height: 60px;
            margin-bottom: 22px;
        }
        .dd h3.panel-title,
        .dd-dragel h3.panel-title {
            padding-left: 55px;
        }
        .dd-dragel .panel-body,
        .dd-dragging .panel-body {
            display: none !important;
        }
        .order-handle {
            z-index: 1;
            position: absolute;
            padding: 20px 15px 19px;
            background: rgba(255,255,255,0.2);
            font-size: 15px;
            color: #fff;
            line-height: 20px;
            box-shadow: inset -2px 0px 2px rgba(0,0,0,0.1);
            cursor: move;
        }
    </style>
@stop

@section('page_header')
    <h1 class="page-title">
        <i class="{{ $dataType->icon }}"></i>
        {{ __('voyager::generic.'.(isset($form->id) ? 'edit' : 'add')).' '.$dataType->display_name_singular }}
    </h1>
@stop

@section('content')
    <div class="page-content edit-add container-fluid">
        @include('voyager::alerts')

        <div class="row">
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
                                <label for="title">Title</label>
                                <input name="title" class="form-control" type="text"
                                       @if (isset($form->title)) value="{{ $form->title }}" @endif required>
                            </div>

                            @if (isset($form->id))
                                <div class="form-group">
                                    <label for="shortcode">Shortcode
                                        <small>(Paste this code into a text field to display the form)</small>
                                    </label>
                                    <input
                                        name="shortcode"
                                        class="form-control"
                                        type="text"
                                        value="{{ "{!" . "! forms($form->id) !" . "!}" }}"
                                        readonly
                                        data-select-all-contents
                                    />
                                </div>
                            @endif

                            <div class="form-group">
                                <label for="mailto">Mail To
                                    <small>(Separate multiple with ',')</small>
                                </label>
                                <input
                                    name="mailto"
                                    class="form-control"
                                    type="text"
                                    @if (isset($form->mailto)) value="{{ $form->mailto }}" @endif
                                    placeholder="{{ setting('forms.default_to_email') }}"
                                />
                            </div>

                            <div class="form-group">
                                <label for="layout">Layout</label>
                                <select class="form-control" name="layout" id="layout">
                                    @foreach($layouts as $layout)
                                        <option
                                            value="{{ $layout }}"
                                            @if (isset($form->layout) && $form->layout === $layout)
                                            selected="selected"
                                            @endif
                                        >
                                            {{ ucwords(str_replace(array('_', '-'), ' ', $layout)) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="email_template">Email Template</label>
                                <select class="form-control" name="email_template" id="email_template">
                                    @foreach($emailTemplates as $emailTemplate)
                                        <option
                                            value="{{ $emailTemplate }}"
                                            @if (isset($form->email_template) && $form->email_template === $emailTemplate)
                                            selected="selected"
                                            @endif
                                        >
                                            {{ ucwords(str_replace(array('_', '-'), ' ', $emailTemplate)) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="message_success">Success Message</label>
                                <input
                                    name="message_success"
                                    class="form-control"
                                    type="text"
                                    @if (!isset($form)) value="Success! Thanks for your enquiry." @endif
                                    @if (isset($form->message_success)) value="{{ $form->message_success }}" @endif
                                    placeholder="Thanks for your enquiry"
                                />
                            </div>

                            <div class="form-group">
                                <label for="hook">Event Hook
                                    <small>(Fires after form is submitted)</small>
                                </label>
                                <input name="hook" class="form-control" type="text"
                                       @if (isset($form->hook)) value="{{ $form->hook }}" @endif>
                            </div>

                            <button type="submit" class="btn btn-primary">
                                {{ __('voyager::generic.'.(isset($form->id) ? 'update' : 'add')) }}
                                {{ $dataType->display_name_singular }}
                            </button>
                        </form>
                    </div>
                </div>

                @if (isset($form))
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
                                        class="btn btn-success btn-sm">{{ __('voyager::generic.add') }}</button>
                            </form>
                        </div> <!-- /.panel-body -->
                    </div> <!-- /.panel -->
                @endif
            </div>

            <div class="col-md-8">
                @if (isset($form))
                    <div class="dd">
                        <ol class="dd-list">
                            @each('voyager-forms::inputs.edit-add', $form->inputs, 'input')
                        </ol>
                    </div> <!-- /.dd -->
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

            /**
             * Select all text on focus
             */
            $("[data-select-all-contents]").on("click", function () {
               $(this).select();
            });

            /**
             * ORDER Inputs
             */
             // Init drag 'n drop
            $('.dd').nestable({ handleClass: 'order-handle', maxDepth: 1 });

            // Close all panels when dragging
            $('.order-handle').on('mousedown', function() { $('.dd').addClass('dd-dragging'); });

            // Fire request when drag complete
            $('.dd').on('change', function (e) {
                // Only when it's a result of drag and drop
                // -- Otherwise this triggers on every form change within .dd
                if ($('.dd').hasClass('dd-dragging')) {
                    // And reopen panels once drag has finished
                    $('.dd').removeClass('dd-dragging');

                    // Post the request
                    $.post('{{ route('voyager.forms.order') }}', {
                        order: JSON.stringify($('.dd').nestable('serialize')),
                        _token: '{{ csrf_token() }}'
                    }, function (data) {
                        toastr.success("Order saved");
                    });
                }
            });
        });
    </script>
@stop

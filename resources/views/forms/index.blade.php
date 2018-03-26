@extends('voyager::master')

@section('page_title', __('voyager.generic.viewing').' '.$dataType->display_name_plural)

@section('page_header')
    <div class="container-fluid">
        <h1 class="page-title">
            <i class="{{ $dataType->icon }}"></i> {{ $dataType->display_name_plural }}
        </h1>
        <a href="{{ route('voyager.'.$dataType->slug.'.create') }}" class="btn btn-success btn-add-new">
            <i class="voyager-plus"></i> <span>{{ __('voyager.generic.add_new') }}</span>
        </a>
        @can('delete',app($dataType->model_name))
            @include('voyager::partials.bulk-delete')
        @endcan
        @include('voyager::multilingual.language-selector')
    </div>
@stop

@section('content')
    <div class="page-content browse container-fluid">
        @include('voyager::alerts')
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-bordered">
                    <div class="panel-body">
                        @if (!$forms || count($forms) === 0)
                            No forms found, try adding one.
                        @else
                            <div class="table-responsive">
                                <table id="dataTable" class="table table-hover">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Shortcode</th>
                                        <th>Title</th>
                                        <th>Layout</th>
                                        <th>Mail To</th>
                                        <th>Hook</th>
                                        <th>Updated At</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>

                                    @foreach ($forms as $form)
                                        <tr>
                                            <td>{{ $form->id }}</td>
                                            <td>{{ "{!" . "! forms($form->id) !" . "!}" }}</td>
                                            <td>{{ $form->title }}</td>
                                            <td>{{ $form->layout or 'None' }}</td>
                                            <td>{{ $form->mailto }}</td>
                                            <td>{{ $form->hook or 'None' }}</td>
                                            <td>{{ $form->updated_at }}</td>
                                            <td>
                                                <a href="javascript:;" title="{{ __('voyager.generic.delete') }}"
                                                   class="btn btn-sm btn-danger pull-right delete"
                                                   data-id="{{ $form->{$form->getKeyName()} }}"
                                                   id="delete-{{ $form->{$form->getKeyName()} }}">
                                                    <i class="voyager-trash"></i> <span
                                                        class="hidden-xs hidden-sm">{{ __('voyager.generic.delete') }}</span>
                                                </a>
                                                <a href="{{ route('voyager.forms.edit', $form->{$form->getKeyName()}) }}"
                                                   title="{{ __('Edit') }}"
                                                   class="btn btn-sm btn-primary pull-right edit">
                                                    <i class="voyager-edit"></i> <span
                                                        class="hidden-xs hidden-sm">{{ __('Edit') }}</span>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Single delete modal --}}
    <div class="modal modal-danger fade" tabindex="-1" id="delete_modal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"
                            aria-label="{{ __('voyager.generic.close') }}"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><i
                            class="voyager-trash"></i> {{ __('voyager.generic.delete_question') }} {{ strtolower($dataType->display_name_singular) }}
                        ?</h4>
                </div>
                <div class="modal-footer">
                    <form action="{{ route('voyager.'.$dataType->slug.'.index') }}" id="delete_form" method="POST">
                        {{ method_field("DELETE") }}
                        {{ csrf_field() }}
                        <input type="submit" class="btn btn-danger pull-right delete-confirm"
                               value="{{ __('voyager.generic.delete_confirm') }} {{ strtolower($dataType->display_name_singular) }}">
                    </form>
                    <button type="button" class="btn btn-default pull-right"
                            data-dismiss="modal">{{ __('voyager.generic.cancel') }}</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
@stop

@section('javascript')
    <!-- DataTables -->
    @if(!$dataType->server_side && config('dashboard.data_tables.responsive'))
        <script src="{{ voyager_asset('lib/js/dataTables.responsive.min.js') }}"></script>
    @endif
    <script>
        var deleteFormAction;
        $('td').on('click', '.delete', function (e) {
            var form = $('#delete_form')[0];

            if (!deleteFormAction) { // Save form action initial value
                deleteFormAction = form.action;
            }

            form.action = deleteFormAction.match(/\/[0-9]+$/)
                ? deleteFormAction.replace(/([0-9]+$)/, $(this).data('id'))
                : deleteFormAction + '/' + $(this).data('id');
            console.log(form.action);

            $('#delete_modal').modal('show');
        });
    </script>
@stop

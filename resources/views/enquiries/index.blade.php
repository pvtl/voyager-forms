@extends('voyager::master')

@section('page_title', __('voyager.generic.viewing').' '.$dataType->display_name_plural)

@section('page_header')
    <div class="container-fluid">
        <h1 class="page-title">
            <i class="{{ $dataType->icon }}"></i> {{ $dataType->display_name_plural }}
        </h1>

        @include('voyager::partials.bulk-delete')
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
                        @if (!$enquiries || count($enquiries) === 0)
                            No enquiries found.
                        @else
                            <div class="table-responsive">
                                <table id="dataTable" class="table table-hover">
                                    <thead>
                                    <tr>
                                        @can('delete',app($dataType->model_name))
                                            <th></th>
                                        @endcan
                                        @foreach($dataType->browseRows as $row)
                                            <th>
                                                @if ($dataType->server_side)
                                                    <a href="{{ $row->sortByUrl() }}">
                                                        @endif
                                                        {{ $row->display_name }}
                                                        @if ($dataType->server_side)
                                                            @if ($row->isCurrentSortField())
                                                                @if (!isset($_GET['sort_order']) || $_GET['sort_order'] == 'asc')
                                                                    <i class="voyager-angle-up pull-right"></i>
                                                                @else
                                                                    <i class="voyager-angle-down pull-right"></i>
                                                                @endif
                                                            @endif
                                                    </a>
                                                @endif
                                            </th>
                                        @endforeach
                                        <th class="actions">{{ __('voyager.generic.actions') }}</th>
                                    </tr>
                                    </thead>

                                    @foreach ($enquiries as $enquiry)
                                        <tr>
                                            <td>
                                                <input type="checkbox" name="row_id" id="checkbox_{{ $enquiry->id }}" value="{{ $enquiry->id }}">
                                            </td>
                                            <td>
                                                <a href="{{ route('voyager.forms.edit', $enquiry->form_id) }}">
                                                    {{ $enquiry->form_id }} (View Associated Form)
                                                </a>
                                            </td>
                                            <td>{{ $enquiry->mailto }}</td>
                                            <td>
                                                @php $count = 0 @endphp
                                                @foreach ($enquiry->data as $key => $value)
                                                    @php $count++ @endphp
                                                    @if ($count > 2) @continue @endif

                                                    <b>{{ $key }}</b>: {{ $value }}<br>
                                                @endforeach
                                            </td>
                                            <td>{{ $enquiry->created_at }}</td>
                                            <td>
                                                <a href="javascript:;" title="{{ __('voyager.generic.delete') }}"
                                                   class="btn btn-sm btn-danger pull-right delete"
                                                   data-id="{{ $enquiry->{$enquiry->getKeyName()} }}"
                                                   id="delete-{{ $enquiry->{$enquiry->getKeyName()} }}">
                                                    <i class="voyager-trash"></i> <span
                                                        class="hidden-xs hidden-sm">{{ __('voyager.generic.delete') }}</span>
                                                </a>
                                                <a href="{{ route('voyager.enquiries.show', $enquiry->{$enquiry->getKeyName()}) }}"
                                                   title="{{ __('View') }}"
                                                   class="btn btn-sm btn-warning pull-right view">
                                                    <i class="voyager-eye"></i> <span
                                                        class="hidden-xs hidden-sm">{{ __('View') }}</span>
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
                            class="voyager-trash"></i> {{ __('voyager.generic.delete_question') }} {{ strtolower($dataType->display_name_singular) }}?</h4>
                </div>
                <div class="modal-footer">
                    <form action="{{ route('voyager.'.$dataType->slug.'.index') }}" id="delete_enquiry" method="POST">
                        {{ method_field("DELETE") }}
                        {{ csrf_field() }}
                        <input type="submit" class="btn btn-danger pull-right delete-confirm"
                               value="{{ __('voyager.generic.delete_confirm') }}">
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
            var form = $('#delete_enquiry')[0];

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

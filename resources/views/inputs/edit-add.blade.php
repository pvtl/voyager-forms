<li class="dd-item" data-id="{{ $input->id }}" id="input-id-{{ $input->id }}">
    <i class="glyphicon glyphicon-sort order-handle"></i>
    <div class="panel panel-bordered panel-info">
        <div class="panel-heading">
            <h3 class="panel-title">{{ ucwords(str_replace('_', ' ', $input->type)) }} Input</h3>
        </div> <!-- /.panel-heading -->

        <div class="panel-body">
            <form role="form" action="{{ route('voyager.inputs.update', $input->id) }}"
                    method="POST"
                    enctype="multipart/form-data">
                {{ csrf_field() }}
                {{ method_field("PUT") }}

                <div class="row">
                    <div class="col-md-4 no-bottom-margin">
                        <div class="form-group">
                            <label for="label">Type</label>
                            <select class="form-control" name="type" id="type" required>
                                @foreach (config('voyager-forms.available_inputs') as $key => $value)
                                    {{ $key }}
                                    <option value="{{ $key }}" @if ($key === $input->type) selected @endif>{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4 no-bottom-margin">
                        <div class="form-group">
                            <label for="label">Label</label>
                            <input name="label" class="form-control" id="label" value="{{ $input->label }}" required>
                        </div>
                    </div>

                    @if (in_array($input->type, ['checkbox', 'select', 'radio']))
                        <div class="col-md-4 no-bottom-margin">
                            <div class="form-group">
                                <label for="options">Options <small>(Separated with ',')</small></label>
                                <input name="options" class="form-control" id="options" value="{{ $input->options }}"
                                        required>
                            </div>
                        </div>
                    @endif

                    <div class="col-md-4 no-bottom-margin">
                        <div class="form-group">
                            <label for="class">CSS Classes</label>
                            <input name="class" class="form-control" id="class" value="{{ $input->class }}">
                        </div>
                    </div>

                    <div class="col-md-4 no-bottom-margin">
                        <div class="form-group">
                            <input
                                type="checkbox"
                                name="required"
                                id="required"
                                data-name="required"
                                class="toggleswitch"
                                value="1"
                                data-on="Yes" {{ $input->required ? 'checked="checked"' : '' }}
                                data-off="No"
                            />
                            <label for="required"> &nbsp;Input Required</label>
                        </div> <!-- /.form-group -->
                    </div>
                </div> <!-- /.row -->

                <input type="hidden" name="input_id" value="{{ $input->id }}"/>
                <button type="submit"
                        style="float:left"
                        class="btn btn-success btn-sm">{{ __('Update This Input') }}</button>
            </form>

            <form method="POST" action="{{ route('voyager.inputs.destroy', $input->id) }}">
                {{ method_field("DELETE") }}
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <span class="btn-group-xs">
                    <button
                        data-delete-input-btn
                        type="submit"
                        style="float:right; margin-top:12px"
                        class="btn btn-danger btn-xs delete"
                    >{{ __('voyager::generic.delete') }} This Input</button>
                </span>
            </form>
        </div> <!-- /.panel-body -->
    </div> <!-- /.panel -->
</li>

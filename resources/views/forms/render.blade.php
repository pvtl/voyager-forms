<form action="{{ route('voyager.enquiries.store') }}" method="POST" id="{{ $form->title }}">
    {{ csrf_field() }}

    <input type="hidden" name="id" value="{{ $form->id }}">

    @foreach ($form->inputs as $input)
        @php
            $row = $input;
            $row->field = $row->label;

            $options = $input->options;
        @endphp

        <div class="{{ $input->class }}">
            <label for="{{ $input->label }}">{{ $input->label }}</label>

            @if (in_array($input->type, ['text', 'number', 'email']))
                @include('voyager::formfields.text')
            @endif

            @if ($input->type === 'text_area')
                @include('voyager::formfields.text_area')
            @endif

            @if ($input->type === 'checkbox')
                @include('voyager::formfields.checkbox')
            @endif

            @if ($input->type === 'select')
                @include('voyager::formfields.select_dropdown')
            @endif

            @if ($input->type === 'radio')
                @include('voyager::formfields.radio_btn')
            @endif

        </div>
    @endforeach

    <button type="submit" value="submit" class="btn btn-primary">Submit</button>
</form>

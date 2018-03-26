<form action="{{ route('voyager.enquiries.store') }}" method="POST" id="{{ $form->title }}">
    {{ csrf_field() }}

    <input type="hidden" name="id" value="{{ $form->id }}">

    @foreach ($form->inputs as $input)
        <div class="{{ $input->class }}">
            <label for="{{ $input->label }}">{{ $input->label }}</label>

            @if (in_array($input->type, ['text', 'number', 'email']))
                <input name="{{ $input->label }}" type="text" @if ($input->required) required @endif>
            @endif

            @if ($input->type === 'text_area')
                <textarea name="{{ $input->label }}" @if ($input->required) required @endif></textarea>
            @endif

            @if (in_array($input->type, ['radio', 'checkbox']))
                @foreach (explode(', ', $input->options) as $option)
                    <label for="{{ $option }}-{{ $input->type }}">{{ ucwords($option) }}
                        <input id="{{ $option }}-{{ $input->type }}" name="{{ $input->label }}"
                               type="{{ $input->type }}">
                    </label>
                @endforeach
            @endif

            @if ($input->type === 'select')
                <select name="{{ $input->label }}" @if ($input->required) required @endif>
                    <option value="">-- Select --</option>

                    @foreach (explode(', ', $input->options) as $option)
                        <option value="{{ $option }}">{{ $option }}</option>
                    @endforeach
                </select>
            @endif
        </div>
    @endforeach

    <button type="submit" value="submit" class="button">Submit</button>
</form>

<form action="{{ route('voyager.enquiries.submit', ['id' => $form->id]) }}" method="POST" id="{{ $form->title }}">
    {{ csrf_field() }}

    @if (session('success'))
        <div class="callout success">{{ session('success') }}</div>
    @endif

    @foreach ($form->inputs as $input)
        <div class="{{ $input->class }}">
            @if (in_array($input->type, ['text', 'number', 'email']))
                <label for="{{ $input->label }}">
                    {{ $input->label }}
                    <input name="{{ $input->label }}" type="{{ $input->type }}" @if ($input->required) required @endif>
                </label>
            @endif

            @if ($input->type === 'text_area')
                <label for="{{ $input->label }}">
                    {{ $input->label }}
                    <textarea name="{{ $input->label }}" @if ($input->required) required @endif></textarea>
                </label>
            @endif

            @if ($input->type === 'select')
                <label for="{{ $input->label }}">
                    {{ $input->label }}
                    <select name="{{ $input->label }}" @if ($input->required) required @endif>
                        <option value="">-- Select --</option>

                        @foreach (explode(', ', $input->options) as $option)
                            <option value="{{ $option }}">{{ $option }}</option>
                        @endforeach
                    </select>
                </label>
            @endif

            @if (in_array($input->type, ['radio', 'checkbox']))
                <fieldset class="fieldset medium-12 cell">
                    <legend>{{ $input->label }}</legend>
                    @foreach (explode(', ', $input->options) as $option)
                        <input
                            id="{{ $option }}-{{ $input->type }}"
                            name="{{ $input->label }}"
                            type="{{ $input->type }}"
                        >
                        <label for="{{ $option }}-{{ $input->type }}">{{ ucwords($option) }}</label>
                    @endforeach
                </fieldset>
            @endif
        </div>
    @endforeach

    <button
        @if (setting('admin.google_recaptcha_site_key') && setting('admin.google_recaptcha_secret_key'))
        class="button g-recaptcha"
        data-sitekey="{{ setting('admin.google_recaptcha_site_key') }}"
        onclick="setForm({{ $form->title }})"
        data-callback="onSubmit"
        @else
        class="button"
        @endif
        id="submit"
        type="submit"
        value="submit"
    >
        Submit
    </button>
</form>

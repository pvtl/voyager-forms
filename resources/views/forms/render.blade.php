<form id="{{ $form->title }}" action="{{ route('voyager.enquiries.submit', ['id' => $form->id]) }}" method="POST" enctype="multipart/form-data">
    {{ csrf_field() }}

    @if (session('success'))
        <div class="callout success">{{ session('success') }}</div>
    @endif

    @php $groupCounter = 0; @endphp

    @foreach ($form->inputs as $input)
        @if ($input->type === 'group')
            @if ($groupCounter % 2 === 0)
                <span class="{{ $input->class }} groupedInputTitle"> {{ $input->label }}</span>
                <div class="{{ $input->class }} groupedInput"> 
            @else
                </div> 
            @endif
            @php $groupCounter++; @endphp
        @else

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
                                value="{{ $option }}"
                            >
                            <label for="{{ $option }}-{{ $input->type }}">{{ ucwords($option) }}</label>
                        @endforeach
                    </fieldset>
                @endif

                @if ($input->type === 'file')
                    <label for="{{ $input->label }}">
                        {{ $input->label }}
                        <input type="file" name="{{ $input->label }}" accept="{{ $input->options }}" @if ($input->required) required @endif>
                    </label>
                @endif
                
                @error($input->label)
                    <div class="error">
                        {{$message}}
                    </div>
                @enderror
            </div>
        @endif
    @endforeach

    @if ($groupCounter % 2 === 1)
        </div>
    @endif

    @if (setting('admin.google_recaptcha_site_key'))
        <button
            class="button g-recaptcha"
            data-badge="inline"
            data-sitekey="{{ setting('admin.google_recaptcha_site_key') }}"
            data-callback="onSubmit" onclick="setFormId('{{ $form->title }}')"
        >
            @if($input->type === 'submit') 
                {{$input->label}}
            @else
                Submit
            @endif
        </button>
    @else
        <button class="button" id="submit" type="submit" value="submit">
            @if($input->type === 'submit') 
                {{$input->label}}
            @else
                Submit
            @endif
        </button>
    @endif
</form>

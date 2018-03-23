<form action="{{ route('voyager.enquiries.store') }}" method="POST">
    {{ csrf_field() }}

    <input type="hidden" name="id" value="{{ $form->id }}">

    @foreach ($form->inputs as $input)
        <div class="{{ $input->class }}">
            <label for="{{ $input->label }}">{{ $input->label }}</label>
            <input name="{{ $input->label }}" type="{{ $input->type }}" @if ($input->required) required @endif>
        </div>
    @endforeach

    <button type="submit" value="submit">Submit</button>
</form>

<form action="{{ route('voyager.enquiries.store') }}" method="POST">
    {{ csrf_token() }}

    @foreach ($form->inputs as $input)
        <div class="{{ $input->class }}">
            <label for="{{ $input->label }}">{{ $input->label }}</label>
            <input name="{{ $input->label }}" type="{{ $input->type }}">
        </div>
    @endforeach

    <button type="submit" value="submit">Submit</button>
</form>

<select class="custom-select">
    <option value="" selected>All Companies</option>
    @foreach ($companies as $key => $name)
        <option value="{{ $key }}">{{ $name }}</option>
    @endforeach
</select>

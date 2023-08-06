<select class="custom-select search-select" name="company_id" onchange="this.form.submit();">
    <option value="" selected>All Companies</option>
    @foreach ($companies as $key => $name)
        <option value="{{ $key }}" @if ($key == request()->query('company_id')) selected @endif>{{ $name }}
        </option>
    @endforeach
</select>
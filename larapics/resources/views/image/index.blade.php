<h1>All images</h1>

<a href="{{route('images.create')}}">Upload image</a>

@if ($message = session('message'))
    <div>{{$message}}</div>
@endif

@foreach ($images as $image)
    <div>
        <a href="{{ $image->permalink() }}">
            <img src="{{ $image->fileUrl() }}" alt="{{ $image->title }}" width="300">
        </a>
        <div>
            <a href="{{ $image->route('edit') }}">Edit</a> |
            <form action="{{$image->route('destroy')}}" method="POST" style="display: inline">
                @csrf
                @method('delete')
                <button type="submit" onclick="return confirm('Are you sure?')">Delete</button>
            </form>
        </div>
        
    </div>
@endforeach
<ul class="mt-10 space-y-10">
    @foreach ($posts as $index => $post)
        <x-post-item :post="$post" />
    @endforeach
</ul>

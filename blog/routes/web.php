<?php

use App\Models\Post;
use Illuminate\Support\Facades\Route;
use Spatie\Sheets\Facades\Sheets;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
 */

Route::get('/', function () {
    $posts = Sheets::collection('posts')->all();
    return view('posts.index', compact('posts'));
});
Route::get('/posts/{slug}', function ($slug) {
    $post = Sheets::collection('posts')->all()->where('slug',$slug)->first();

    abort_if(is_null($post),404);

    return view('posts.show', compact('post'));
})->name('posts.show');

Route::get('/authors/{author}',function($author){
    $posts = Sheets::collection('posts')
        ->all()
        ->filter(fn (Post $post) => $post->author === $author);
    return view('authors.show', [
        'posts' => $posts,
        'authorName' => $posts->first()->author_name
    ]);
})->name('author.show');

Route::get('/tags/{tag}',function($tag){
    $posts = Sheets::collection('posts')
        ->all()
        ->filter(fn (Post $post) => in_array($tag, $post->tags));

    return view('tags.show', [
        'posts' => $posts,
        'tag' => $tag
    ]);
})->name('tags.show');
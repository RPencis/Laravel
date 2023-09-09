<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReplayCommentRequest;
use App\Models\Comment;

class ReplyCommentController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function create(Comment $comment)
    {
        return view('comments.reply', compact('comment'));
    }
    public function store(Comment $comment, ReplayCommentRequest $request)
    {
        Comment::create(array_merge($request->getData(), ['approved' => true]));
        $comment->update(['approved' => true]);

        return to_route('comments.index')->with('message', "Your reply has been sent");
    }

}

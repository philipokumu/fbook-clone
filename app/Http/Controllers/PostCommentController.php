<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Http\Resources\CommentCollection;

class PostCommentController extends Controller
{
    public function store(Post $post)
    {
        $data = request()->validate([
            'body'=> 'required',
        ]);

        //Get the post related to the comment and create it in the db
        $post->comments()->create(array_merge($data,[
            'user_id' => auth()->user()->id,
        ]));

        return new CommentCollection($post->comments);
    }
}

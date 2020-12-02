<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Friend;
use App\Http\Resources\Post as PostResource;
use App\Http\Resources\PostCollection;
use Intervention\Image\Facades\Image;

class PostController extends Controller
{

    public function index()
    {
        //Query all the friendships
        $friends = Friend::friendships();

        if($friends->isEmpty()) {
            return new PostCollection(request()->user()->posts);
        };

        // return new PostCollection(request()->posts);
        return new PostCollection(
            Post::whereIn('user_id', [$friends->pluck('user_id'), $friends->pluck('friend_id')])->get()
        );
    }

    public function store()
    {
        $data = request()->validate([
            'body'=>'',
            'image'=>'',
            'width'=>'',
            'height'=>'',

        ]);

        if(isset($data['image'])){
            $image = 'storage/'.$data['image']->store('post-images', 'public');

            //Resized image to avoid overly large images and replace original image
            Image::make($data['image'])
                ->fit($data['width'],$data['height'])
                ->save(storage_path('app/public/post-images/'.$data['image']->hashName()));
        }

        $post = request()->user()->posts()->create([
            'body'=> $data['body'],
            'image'=> $image ?? null, 
        ]);

        return new PostResource($post);
    }
}

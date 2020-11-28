<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\User as UserResource;
use App\Http\Resources\LikeCollection;

class Post extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data'=>[
                'type'=>'posts',
                'post_id'=>$this->id,
                'attributes'=>[
                    'posted_by'=>new UserResource($this->user),
                    'likes'=> new LikeCollection($this->likes),
                    'body'=>$this->body,
                    'posted_at'=> $this->created_at->diffForHumans(),
                    'image'=> $this->image,
                ]
            ],
            'links'=> [
                'self'=> url('/posts/'.$this->id),
            ]
        ];
    }
}

<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserImage extends JsonResource
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
                'type'=>'image',
                'user_image_id'=> $this->id,
                'attributes'=> [
                    'path'=> url($this->path),
                    'width'=> $this->width,
                    'height'=> $this->height,
                    'location'=> $this->location,
                ]
            ],
            'self'=> [
                'links'=> url('/users'. $this->user_id),
            ]
        ];
    }
}

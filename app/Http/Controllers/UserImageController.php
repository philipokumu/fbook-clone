<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\UserImage as UserImageResource;
use Intervention\Image\Facades\Image;

class UserImageController extends Controller
{
    public function store()
    {
        $data = request()->validate([
            'image' => 'required',
            'width' => 'required',
            'height' => 'required',
            'location' => 'required',
        ]);

        //Original image saved
        $image = $data['image']->store('user-images','public');

        //Resized image to avoid overly large images and replace original image
        Image::make($data['image'])
            ->fit($data['width'],$data['height'])
            ->save(storage_path('app/public/user-images/'.$data['image']->hashName()));

        $userImage = auth()->user()->images()->create([
            'path'=> 'storage/'.$image,
            'width'=> $data['width'],
            'height'=> $data['height'],
            'location'=> $data['location'],
        ]);

        return new UserImageResource($userImage);
    }
}

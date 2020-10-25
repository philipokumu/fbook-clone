<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Friend;
use App\Http\Resources\Friend as FriendResource;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class FriendRequestResponseController extends Controller
{
    public function store()
    {
        $data = request()->validate([
            'user_id' => 'required',
            'status' => 'required',
        ]);

        try {
            $friendRequest = Friend::where('user_id', $data['user_id'])
            ->where('friend_id', auth()->user()->id)
            ->firstOrFail();
        } catch (ModelNotFoundException $e) {
            throw new \App\Exceptions\FriendRequestNotFoundException();
        }

        $friendRequest->update(array_merge($data, [
            'confirmed_at' => now(),
        ]));

        return new FriendResource($friendRequest);
    }
}

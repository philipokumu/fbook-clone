<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Friend;
use App\Models\User;
use App\Http\Resources\Friend as FriendResource;

class FriendRequestController extends Controller
{
    public function Store()
    {
        $data = request()->validate([
            'friend_id' => ''
        ]);

        User::find($data['friend_id'])
            ->friends()->attach(auth()->user());

        return new FriendResource(
            Friend::where('user_id', auth()->user()->id)
                ->where('friend_id', $data['friend_id'])
                ->first()
        );

    }
}

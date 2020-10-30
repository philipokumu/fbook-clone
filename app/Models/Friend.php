<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Friend extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $dates = ['confirmed_at'];

    //A function to check whether the user is friend request sender or receiver and then call correct data
    public static function friendship($userId)
    {
        return (new static())
            ->where(function($query) use ($userId){
                return $query->where('user_id', auth()->user()->id)
                ->where('friend_id', $userId);
            })

            ->orWhere(function($query) use ($userId){
                return $query->where('friend_id', auth()->user()->id)
                ->where('user_id', $userId);
            })->first();
    }

    //A function to check whether the user is friend request sender or receiver and then call correct data
    public static function friendships()
    {
        return (new static())
            ->whereNotNull('confirmed_at')
            ->where(function($query){
                return $query->where('user_id', auth()->user()->id)
                ->where('friend_id', auth()->user()->id);
            })->get();
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Events\ChatEvent;

class ChatController extends Controller
{
    public function chat()
    {
        return view('chat');
    }

    public function send(Request $request)
    {
        $user = auth()->user();
        event(new ChatEvent($request->message, $user));
    }

    // public function send()
    // {
    //     $message = 'hello';
    //     $user = auth()->user()->name;
    //     event(new ChatEvent($message, $user));
    // }
}

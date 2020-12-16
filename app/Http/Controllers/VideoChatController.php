<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class VideoChatController extends Controller
{
    public function callUser(Request $request)
    {
        $data['userToCall'] = $request->user_to_call;
        $data['signalData'] = $request->signal_data;
        $data['from'] = Auth::id();
        $data['type'] = 'incomingCall';

        broadcast(new StartVideoChat($data))->toOthers();
    }
    public function acceptCall(Request $request)
    {
        $data['signal'] = $request->signal;
        $data['to'] = $request->to;
        $data['type'] = 'callAccepted';
        broadcast(new StartVideoChat($data))->toOthers();
    }

    public function index()
    {
        // fetch all users apart from the authenticated user
    $users = User::where('id', '<>', auth()->id())->get();
    return view('video-chat', ['users' => $users]);
    }
}

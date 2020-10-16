<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\User as UserResource;
use App\Models\User;

class UserController extends Controller
{
    public function show(User $user)
    {
        return new userResource($user);
    }
}

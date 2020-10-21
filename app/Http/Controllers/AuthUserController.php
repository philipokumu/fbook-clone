<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\User as UserResource;
use App\Models\User;

class AuthUserController extends Controller
{
    public function Show()
    {
        return new UserResource(auth()->user());
    }
}

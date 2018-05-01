<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserFollowController extends Controller
{
    public function store(User $user)
    {
        return auth()->user()->follow($user->id);
    }

    public function destroy(User $user)
    {
       return auth()->user()->unfollow($user->id);
    }
}

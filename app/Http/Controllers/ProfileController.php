<?php

namespace App\Http\Controllers;

use App\User;
use App\Activity;

class ProfileController extends Controller
{
    public function show(User $user)
    {
        //return $this->getActivity($user);
        return view('profiles.show', [
            'profileUser' => $user,
            'activities' => Activity::feed($user) //TODO: Activities for user
        ]);
    }

    public function like(User $user)
    {
        $user->like();
    }

    public function unlike(User $user)
    {
        $user->unlike();
    }
}

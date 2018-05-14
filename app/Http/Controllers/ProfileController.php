<?php

namespace App\Http\Controllers;

use App\User;
use App\Activity;

class ProfileController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth', 'confirmed'])->except('show');
    }

    /**
     * @param User $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(User $user)
    {
        return view('profiles.show', [
            'profileUser' => $user,
            'activities' => Activity::feed($user) //TODO: Activities for user
        ]);
    }

    /**
     * @param User $user
     */
    public function like(User $user)
    {
        $user->like();
    }

    /**
     * @param User $user
     */
    public function unlike(User $user)
    {
        $user->unlike();
    }
}

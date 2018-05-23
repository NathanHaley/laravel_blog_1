<?php

namespace App\Http\Controllers\Api;

use App\User;

/**
 * Class UserFollowController
 * @package App\Http\Controllers
 */
class UserFollowController extends ApiController
{

    public function __construct()
    {
        $this->middleware(['api.auth']);
    }

    /**
     * @param User $user
     * @return mixed
     */
    public function store(User $user)
    {
        auth()->user()->follow($user->id);

        return $this->respondCreated();
    }

    /**
     * @param User $user
     * @return mixed
     */
    public function destroy(User $user)
    {
        auth()->user()->unfollow($user->id);

        return $this->respondDestroyed();
    }
}

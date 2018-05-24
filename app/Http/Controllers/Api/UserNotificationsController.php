<?php

namespace App\Http\Controllers\Api;

use App\User;

/**
 * Class UserNotificationsController
 * @package App\Http\Controllers
 */
class UserNotificationsController extends ApiController
{
    /**
     * UserNotificationsController constructor.
     */
    public function __construct()
    {
        $this->middleware(['auth', 'confirmed']);
    }

    /**
     * @return mixed
     */
    public function index()
    {
        return auth()->user()->unreadNotifications;

    }

    /**
     * @param User $user
     * @param $notificationId
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($notificationId)
    {
        auth()->user()->notifications()->findOrFail($notificationId)->markAsRead();

        return $this->respondDestroyed();
    }
}

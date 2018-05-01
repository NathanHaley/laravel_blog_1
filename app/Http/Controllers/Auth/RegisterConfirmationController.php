<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;

class RegisterConfirmationController extends Controller
{
    public function index()
    {
        $user = User::where('confirmation_token', request('token'))->first();

        if (! $user) {
            //TODO: Maybe direct to better location
            return redirect(route('home'))->with('flash', 'Unknown token.');
        }

        $user->confirm();

        //TODO: Maybe direct to better location
        return redirect(route('home'))
            ->with('flash', 'Your account is now confirmed!');
    }
}

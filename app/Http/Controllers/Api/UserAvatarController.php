<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class UserAvatarController extends Controller
{
    public function store()
    {
        request()->validate([
            'avatar' => 'required|image|max:10'
        ]);

        Storage::disk('public')->delete(auth()->user()->getOriginal('avatar_path'));

        auth()->user()->update([
            'avatar_path' => request()->file('avatar')->store('avatars', 'public')
        ]);

        return response([auth()->user()->fresh()->avatar_path], 202);
    }
}

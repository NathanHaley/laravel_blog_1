<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\BlogApiException;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response as Http;

class UserAvatarController extends Controller
{
    public function store()
    {
        request()->validate([
            'avatar' => 'required|image|max:10'
        ]);

        try {
            Storage::disk('public')->delete(auth()->user()->getOriginal('avatar_path'));

            auth()->user()->update([
                'avatar_path' => request()->file('avatar')->store('avatars', 'public')
            ]);

            return response([auth()->user()->fresh()->avatar_path], Http::HTTP_CREATED);
        } catch (\Throwable $e) {
            throw new BlogApiException("Attempt to store user avatar failed.");
        }
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Channel;
use App\Http\Controllers\Controller;

class ArchivedChannelController extends Controller
{
    public function show(Channel $channel)
    {
        return $channel;
    }

    /**
     * @param Channel $channel
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store($key)
    {
        $this->authorize('update', Channel::class);

        $channel = Channel::onlyTrashed()->where('slug', $key)->restore();

        return redirect(route('admin.channel.index'))->with('flash', [
            'type' => 'success',
            'message' => 'Channel activated.'
        ]);
    }

    /**
     * @param Channel $channel
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Channel $channel)
    {
        //dd('destroy id '.$channel->id);
        $this->authorize('delete', $channel);

        $channel->delete();

        //dd($channel);

        return redirect(route('admin.channel.index'))->with('flash', [
            'type' => 'warning',
            'message' => 'Channel archived.'
        ]);
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Channel;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ChannelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        $this->authorize('view', Channel::class);

        $channels = Channel::withTrashed()->get();

        return view('admin.channel.index', compact('channels'));
    }

    public function activeList()
    {
        return  Channel::get()->orderBy('name');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
        $this->authorize('update', Channel::class);

        return view('admin.channel.form.page.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(Request $request)
    {
        $this->authorize('update', Channel::class);

        $validData = $request->validate(Channel::validations());

        Channel::create([
            'name' => $validData['name'],
            'description' => $validData['description'],
            'color' => $validData['color']
        ]);

        return redirect(route('admin.channel.index'))->with('flash', [
            'type' => 'success',
            'message' => 'Channel created.'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Channel $channel
     * @return void
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Channel $channel)
    {
        $this->authorize('update', $channel);
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Channel $channel
     * @return void
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Channel $channel)
    {
        $this->authorize('update', $channel);

        return view('admin.channel.form.page.edit', compact('channel'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Channel $channel
     * @return void
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(Request $request, Channel $channel)
    {
        $this->authorize('update', $channel);

        $channel->update($request->validate($channel->validations()));

        return redirect(route('admin.channel.index'))->with('flash', [
            'type' => 'success',
            'message' => 'Channel updated.'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Channel $channel
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Channel $channel)
    {
        $this->authorize('update', $channel);

        $channel->delete();

        return redirect(route('admin.channel.index'))->with('flash', [
            'type' => 'danger',
            'message' => 'Channel deleted.'
        ]);
    }
}

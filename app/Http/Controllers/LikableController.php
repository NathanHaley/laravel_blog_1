<?php

namespace App\Http\Controllers;

use App\Likable;
use Illuminate\Http\Request;

class LikableController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'confirmed']);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $likable->like();

        return response(['status' => 'Like saved.']);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Like  $like
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        $likable->unlike();

        return response(['status' => 'Like deleted.']);
    }
}

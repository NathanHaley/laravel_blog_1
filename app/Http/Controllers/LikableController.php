<?php

namespace App\Http\Controllers;

use App\Likable;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as Http;

class LikableController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'confirmed']);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            throw new \Exception('Something bad happened here.');
            $likable->like();

        } catch (\Throwable $e) {

            throw new BlogApiException($e);

        }

        return response(['status' => 'Like create.'], Http::HTTP_CREATED);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Like $like
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        $likable->unlike();

        return response(['status' => 'Like deleted.']);
    }
}

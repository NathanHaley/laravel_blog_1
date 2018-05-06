<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::where(['featured_banner' => false, 'featured_card' => false, 'locked' => false])->orderby('created_at', 'desc')->paginate(25);
        $banner = Post::where(['featured_banner' => true, 'locked' => false])->first();
        $cards = Post::where(['featured_card' => true, 'locked' => false])->orderby('created_at')->paginate(2);

        return view('index', compact('posts', 'banner', 'cards'));
    }
}

<?php

namespace App\Http\Controllers\Client;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Post;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $posts = Post::orderBy('id', 'DESC')
            ->with(['user'])
            ->paginate(20);

        return view('client.home', compact('posts'));
    }

    public function contact()
    {
        return view('client.contact');
    }

}

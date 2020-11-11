<?php

namespace App\Http\Controllers\Client;

use App\Models\Post;
use App\Http\Controllers\Controller;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::orderBy('id', 'DESC')->paginate();

        return view('client.posts.index', compact('posts'));
    }

    public function show(string $slug)
    {
        $post = Post::where('slug', $slug)->first();

        return view('client.posts.show', compact('post'));
    }
}

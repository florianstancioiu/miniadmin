<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\Post;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $pages_total = Page::count();
        $posts_total = Post::count();
        $users_total = User::count();
        $latest_users = User::orderBy('id', 'DESC')->limit(20)->get();

        return view('admin.dashboard.index', compact(
            'pages_total',
            'posts_total',
            'users_total',
            'latest_users'
        ));
    }
}

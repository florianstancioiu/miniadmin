<?php

namespace App\Http\Controllers\Client;

use App\Models\Page;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PageController extends Controller
{
    public function index()
    {
        $pages = Page::orderBy('id', 'DESC')->paginate();

        return view('client.pages.index', compact('pages'));
    }

    public function show(string $slug)
    {
        $page = Page::where('slug', $slug)->first();

        return view('client.pages.show', compact('page'));
    }
}

<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Parsedown;

class PageController extends Controller
{
    public function show(string $slug)
    {
        $page = Page::where('slug', $slug)->first();
        $page->content = (new Parsedown())->text($page->content);

        return view('client.pages.show', compact('page'));
    }
}

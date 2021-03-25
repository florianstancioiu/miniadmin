<?php

namespace App\Http\Controllers\Admin;

use App\Models\Page;
use App\Http\Controllers\Controller;
use App\Http\Requests\PageStore;
use App\Http\Requests\PageUpdate;
use App\Http\Requests\PageDestroy;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class MediaController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->keyword ?? '';
        $pages = Page::orderBy('id', 'DESC')
            ->search($keyword)
            ->paginate()
            ->appends(request()->query());

        return view('admin.pages.index', compact('pages', 'keyword'));
    }

    public function store(PageStore $request)
    {
        $page = new Page($request->validated());
        $page->slug = Str::slug($request->title);
        $page->user_id = Auth::id();

        try {
            if ($request->hasFile('image')) {
                $page->image = $request->image->store('pages');
            }

            $page->save();

        } catch (\Exception $e) {
            return redirect()
                ->route('admin.pages.index')
                ->withErrors([
                    'An exception was raised while storing the page: ' . $e->getMessage()
                ]);
        }

        return redirect()
            ->route('admin.pages.index')
            ->with('message', 'The page record has been successfully stored');
    }
}

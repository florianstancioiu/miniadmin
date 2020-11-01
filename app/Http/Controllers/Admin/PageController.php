<?php

namespace App\Http\Controllers\Admin;

use App\Models\Page;
use App\Http\Controllers\Controller;
use App\Http\Requests\PageStore;
use App\Http\Requests\PageUpdate;
use App\Http\Requests\PageDestroy;
use Illuminate\Support\Str;

class PageController extends Controller
{
    public function index()
    {
        $pages = Page::orderBy('id', 'DESC')->paginate();

        return view('admin.pages.index', compact('pages'));
    }

    public function create()
    {
        return view('admin.pages.create');
    }

    public function store(PageStore $request)
    {
        $page = new Page($request->validated());
        $page->slug = Str::slug($request->title);

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

    public function edit(Page $page)
    {
        return view('admin.pages.edit', compact('page'));
    }

    public function update(PageUpdate $request, Page $page)
    {
        //
    }

    public function destroy(PageDestroy $request, int $id)
    {
        $page = Page::findOrFail($id);
        $page->delete();

        return redirect(route('admin.pages.index'));
    }
}
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

class PageController extends Controller
{
    public function index(Request $request)
    {
        $this->can('list-pages');

        $keyword = $request->keyword ?? '';
        $pages = Page::orderBy('id', 'DESC')
            ->search($keyword)
            ->paginate()
            ->appends(request()->query());

        $auth_user = Auth::user();
        $can_edit_pages = $auth_user->canUser('edit-pages');
        $can_destroy_pages = $auth_user->canUser('destroy-pages');

        return view('admin.pages.index', compact(
            'pages',
            'keyword',
            'can_edit_pages',
            'can_destroy_pages',
        ));
    }

    public function create()
    {
        $this->can('create-pages');

        return view('admin.pages.create');
    }

    public function store(PageStore $request)
    {
        $this->can('store-pages');

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

    public function edit(int $id)
    {
        $this->can('edit-pages');

        $page = Page::findOrFail($id);

        return view('admin.pages.edit', compact('page'));
    }

    public function update(PageUpdate $request, int $id)
    {
        $this->can('update-pages');

        $page = Page::findOrFail($id);
        $original_image = $page->image;
        $page = $page->fill($request->validated());
        $page->slug = Str::slug($request->title);

        try {
            if ($request->hasFile('image')) {
                // delete existing image
                Storage::delete($original_image);

                // store the new one
                $page->image = $request->image->store('pages');
            }


            $page->save();

        } catch (\Exception $e) {
            return redirect()
                ->route('admin.pages.index')
                ->withErrors([
                    'An exception was raised while updating the page: ' . $e->getMessage()
                ]);
        }

        return redirect()
            ->route('admin.pages.index')
            ->with('message', 'The page record has been successfully updated');
    }

    public function destroy(PageDestroy $request, int $id)
    {
        $this->can('destroy-pages');

        try {
            $page = Page::findOrFail($id);
            // delete existing image
            Storage::delete($page->image);
            // delete record
            $page->delete();
        } catch (\Exception $e) {
            return redirect()
                ->route('admin.pages.index')
                ->withErrors([
                    'An exception was raised while deleting the page: ' . $e->getMessage()
                ]);
        }

        return redirect()
            ->route('admin.pages.index')
            ->with('message', 'The page record has been successfully deleted');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Models\Page;
use App\Http\Controllers\Controller;
use App\Http\Requests\Page\StorePage;
use App\Http\Requests\Page\UpdatePage;
use App\Http\Requests\Page\DestroyPage;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * Authorize the Page policy
     */
    public function __construct()
    {
        $this->authorizeResource(Page::class, 'page');
    }

    /**
     * Retrieve the index items
     */
    public function index(Request $request)
    {
        $auth_user = Auth::user();
        $keyword = $request->keyword ?? '';
        $pages = Page::orderBy('id', 'DESC')
            ->search($keyword)
            ->with(['user'])
            ->paginate()
            ->appends(request()->query());

            if ($auth_user->hasRole('guest')) {
                $pages = Page::orderBy('id', 'DESC')
                ->where('user_id', $auth_user->id)
                ->search($keyword)
                ->with(['user'])
                ->paginate()
                ->appends(request()->query());
        }

        return view('admin.pages.index', compact(
            'pages',
            'keyword',
        ));
    }

    /**
     * Return the create view
     */
    public function create()
    {
        return view('admin.pages.create');
    }

    /**
     * Implement the store functionality
     */
    public function store(StorePage $request)
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
                    __('pages.store_failure') . $e->getMessage()
                ]);
        }

        return redirect()
            ->route('admin.pages.index')
            ->with('message', __('pages.store_success'));
    }

    /**
     * Return the edit view
     */
    public function edit(Page $page)
    {
        return view('admin.pages.edit', compact('page'));
    }

    /**
     * Implement the update functionality
     */
    public function update(UpdatePage $request, int $id)
    {
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
                    __('pages.update_failure') . $e->getMessage()
                ]);
        }

        return redirect()
            ->route('admin.pages.index')
            ->with('message', __('pages.update_success'));
    }

    /**
     * Implement the delete functionality
     */
    public function destroy(DestroyPage $request, Page $page)
    {
        try {
            // delete existing image
            Storage::delete($page->image);
            // delete record
            $page->delete();
        } catch (\Exception $e) {
            return redirect()
                ->route('admin.pages.index')
                ->withErrors([
                    __('pages.destroy_failure') . $e->getMessage()
                ]);
        }

        return redirect()
            ->route('admin.pages.index')
            ->with('message', __('pages.destroy_success'));
    }
}

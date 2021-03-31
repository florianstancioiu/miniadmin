<?php

namespace App\Http\Controllers\Admin;

use App\Models\Post;
use App\Http\Controllers\Controller;
use App\Http\Requests\Post\StorePost;
use App\Http\Requests\Post\UpdatePost;
use App\Http\Requests\Post\DestroyPost;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $this->can('list-posts');

        $keyword = $request->keyword ?? '';
        $posts = Post::orderBy('id', 'DESC')
            ->search($keyword)
            ->paginate()
            ->appends(request()->query());

        $auth_user = Auth::user();
        $can_edit_posts = $auth_user->canUser('edit-posts');
        $can_destroy_posts = $auth_user->canUser('destroy-posts');

        return view('admin.posts.index', compact(
            'posts',
            'keyword',
            'can_edit_posts',
            'can_destroy_posts',
        ));
    }

    public function create()
    {
        $this->can('create-posts');

        return view('admin.posts.create');
    }

    public function store(StorePost $request)
    {
        $this->can('store-posts');

        $post = new Post($request->validated());
        $post->slug = Str::slug($request->title);
        $post->user_id = Auth::id();

        try {
            if ($request->hasFile('image')) {
                $post->image = $request->image->store('posts');
            }

            $post->save();

        } catch (\Exception $e) {
            return redirect()
                ->route('admin.posts.index')
                ->withErrors([
                    __('posts.store_failure') . $e->getMessage()
                ]);
        }

        return redirect()
            ->route('admin.posts.index')
            ->with('message', __('posts.store_success'));
    }

    public function edit(int $id)
    {
        $this->can('edit-posts');

        $post = Post::findOrFail($id);

        return view('admin.posts.edit', compact('post'));
    }

    public function update(UpdatePost $request, int $id)
    {
        $this->can('update-posts');

        $post = Post::findOrFail($id);
        $original_image = $post->image;
        $post = $post->fill($request->validated());
        $post->slug = Str::slug($request->title);

        try {
            if ($request->hasFile('image')) {
                // delete existing image
                Storage::delete($original_image);
                // store the new one
                $post->image = $request->image->store('posts');
            }

            $post->save();
        } catch (\Exception $e) {
            return redirect()
                ->route('admin.posts.index')
                ->withErrors([
                    __('posts.update_failure') . $e->getMessage()
                ]);
        }

        return redirect()
            ->route('admin.posts.index')
            ->with('message', __('posts.update_success'));
    }

    public function destroy(DestroyPost $request, int $id)
    {
        $this->can('destroy-posts');

        try {
            $post = Post::findOrFail($id);
            // delete existing image
            Storage::delete($post->image);
            // delete record
            $post->delete();
        } catch (\Exception $e) {
            return redirect()
                ->route('admin.posts.index')
                ->withErrors([
                    __('posts.destroy_failure') . $e->getMessage()
                ]);
        }

        return redirect()
        ->route('admin.posts.index')
        ->with('message', __('posts.destroy_success'));
    }
}

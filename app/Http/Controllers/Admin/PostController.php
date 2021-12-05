<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Post\DestroyPost;
use App\Http\Requests\Post\StorePost;
use App\Http\Requests\Post\UpdatePost;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PostController extends Controller
{
    /**
     * Authorize the Post policy.
     */
    public function __construct()
    {
        $this->authorizeResource(Post::class, 'post');
    }

    /**
     * Retrieve the index items.
     */
    public function index(Request $request)
    {
        $auth_user = Auth::user();
        $keyword = $request->keyword ?? '';
        $posts = Post::orderBy('id', 'DESC')
            ->search($keyword)
            ->with(['user'])
            ->paginate()
            ->appends(request()->query());

        if ($auth_user->hasRole('guest')) {
            $posts = Post::orderBy('id', 'DESC')
                ->where('user_id', $auth_user->id)
                ->search($keyword)
                ->with(['user'])
                ->paginate()
                ->appends(request()->query());
        }

        return view('admin.posts.index', compact(
            'posts',
            'keyword',
        ));
    }

    /**
     * Return the create view.
     */
    public function create()
    {
        return view('admin.posts.create');
    }

    /**
     * Implement the store functionality.
     */
    public function store(StorePost $request)
    {
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
                    __('posts.store_failure').$e->getMessage(),
                ]);
        }

        return redirect()
            ->route('admin.posts.index')
            ->with('message', __('posts.store_success'));
    }

    /**
     * Return the edit view.
     */
    public function edit(Post $post)
    {
        return view('admin.posts.edit', compact('post'));
    }

    /**
     * Implement the update functionality.
     */
    public function update(UpdatePost $request, Post $post)
    {
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
                    __('posts.update_failure').$e->getMessage(),
                ]);
        }

        return redirect()
            ->route('admin.posts.index')
            ->with('message', __('posts.update_success'));
    }

    /**
     * Implement the delete functionality.
     */
    public function destroy(DestroyPost $request, Post $post)
    {
        try {
            // delete existing image
            Storage::delete($post->image);
            // delete record
            $post->delete();
        } catch (\Exception $e) {
            return redirect()
                ->route('admin.posts.index')
                ->withErrors([
                    __('posts.destroy_failure').$e->getMessage(),
                ]);
        }

        return redirect()
            ->route('admin.posts.index')
            ->with('message', __('posts.destroy_success'));
    }
}

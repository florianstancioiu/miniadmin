<?php

namespace App\Http\Controllers\Admin;

use App\Models\Post;
use App\Http\Controllers\Controller;
use App\Http\Requests\PostStore;
use App\Http\Requests\PostUpdate;
use App\Http\Requests\PostDestroy;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->keyword ?? '';
        $posts = Post::orderBy('id', 'DESC')
            ->search($keyword)
            ->paginate()
            ->appends(request()->query());

        return view('admin.posts.index', compact('posts', 'keyword'));
    }

    public function create()
    {
        return view('admin.posts.create');
    }

    public function store(PostStore $request)
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
                    'An exception was raised while storing the post: ' . $e->getMessage()
                ]);
        }

        return redirect()
            ->route('admin.posts.index')
            ->with('message', 'The post record has been successfully stored');
    }

    public function edit(int $id)
    {
        $post = Post::findOrFail($id);

        return view('admin.posts.edit', compact('post'));
    }

    public function update(PostUpdate $request, int $id)
    {
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
                    'An exception was raised while updating the post: ' . $e->getMessage()
                ]);
        }

        return redirect()
            ->route('admin.posts.index')
            ->with('message', 'The post record has been successfully updated');
    }

    public function destroy(PostDestroy $request, int $id)
    {
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
                    'An exception was raised while deleting the post: ' . $e->getMessage()
                ]);
        }

        return redirect()
        ->route('admin.posts.index')
        ->with('message', 'The post record has been successfully deleted');
    }
}

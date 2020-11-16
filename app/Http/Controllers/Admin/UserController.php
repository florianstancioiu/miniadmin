<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserStore;
use App\Http\Requests\UserUpdate;
use App\Http\Requests\UserDestroy;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('id', 'DESC')->paginate();

        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(UserStore $request)
    {
        $user = new User($request->validated());
        $user->password = Hash::make($request->password);

        try {
            if ($request->hasFile('image')) {
                $user->image = $request->image->store('users');
            }

            $user->save();

        } catch (\Exception $e) {
            return redirect()
                ->route('admin.users.index')
                ->withErrors([
                    'An exception was raised while storing the user: ' . $e->getMessage()
                ]);
        }

        return redirect()
            ->route('admin.users.index')
            ->with('message', 'The user record has been successfully stored');
    }

    public function edit(int $id)
    {
        $user = User::findOrFail($id);

        return view('admin.users.edit', compact('user'));
    }

    public function update(UserUpdate $request, int $id)
    {
        $user = User::findOrFail($id);
        $original_image = $user->image;
        $original_password = $user->password;

        $user = $user->fill($request->validated());
        if (strlen($request->password) >= 6) {
            $user->password = Hash::make($request->password);
        } else {
            $user->password = $original_password;
        }

        try {
            if ($request->hasFile('image')) {
                // delete existing image
                Storage::delete($original_image);

                // store the new one
                $user->image = $request->image->store('users');
            }


            $user->save();

        } catch (\Exception $e) {
            return redirect()
                ->route('admin.users.index')
                ->withErrors([
                    'An exception was raised while updating the user: ' . $e->getMessage()
                ]);
        }

        return redirect()
            ->route('admin.users.index')
            ->with('message', 'The user record has been successfully updated');
    }

    public function destroy(UserDestroy $request, int $id)
    {
        try {
            $user = User::findOrFail($id);
            // delete existing image
            Storage::delete($user->image);
            // delete record
            $user->delete();
        } catch (\Exception $e) {
            return redirect()
                ->route('admin.users.index')
                ->withErrors([
                    'An exception was raised while deleting the user: ' . $e->getMessage()
                ]);
        }

        return redirect()
        ->route('admin.users.index')
        ->with('message', 'The user record has been successfully deleted');
    }
}

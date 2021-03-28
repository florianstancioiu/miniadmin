<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserStore;
use App\Http\Requests\UserUpdate;
use App\Http\Requests\UserUpdatePassword;
use App\Http\Requests\UserDestroy;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $this->can('list-users');

        $keyword = $request->keyword ?? '';
        $users = User::orderBy('id', 'DESC')
            ->search($keyword)
            ->paginate()
            ->appends(request()->query());

        $auth_user = Auth::user();
        $can_edit_users = $auth_user->canUser('edit-users');
        $can_destroy_users = $auth_user->canUser('destroy-users');

        return view('admin.users.index', compact(
            'users',
            'keyword',
            'can_edit_users',
            'can_destroy_users',
        ));
    }

    public function create()
    {
        $this->can('create-users');

        return view('admin.users.create');
    }

    public function store(UserStore $request)
    {
        $this->can('store-users');

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
        $this->can('edit-users');

        $user = User::findOrFail($id);

        return view('admin.users.edit', compact('user'));
    }

    public function update(UserUpdate $request, int $id)
    {
        $this->can('update-users');

        $user = User::findOrFail($id);
        $original_image = $user->image;
        $user = $user->fill($request->validated());

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

    public function updatePassword(UserUpdatePassword $request, int $id)
    {
        $this->can('update-password-users');

        $user = User::findOrFail($id);
        $original_password = $user->password;

        if (strlen($request->password) >= 6) {
            $user->password = Hash::make($request->password);
        } else {
            $user->password = $original_password;
        }

        try {
            $user->save();
        } catch (\Exception $e) {
            return redirect()
                ->route('admin.users.index')
                ->withErrors([
                    'An exception was raised while changing the password: ' . $e->getMessage()
                ]);
        }

        return redirect()
            ->route('admin.users.index')
            ->with('message', 'The user password has been successfully updated');
    }

    public function destroy(UserDestroy $request, int $id)
    {
        $this->can('destroy-users');

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

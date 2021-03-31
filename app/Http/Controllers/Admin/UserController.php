<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Role;
use App\Models\UserRole;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreUser;
use App\Http\Requests\User\UpdateUser;
use App\Http\Requests\User\UpdatePasswordUser;
use App\Http\Requests\User\DestroyUser;
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
            ->with('roles')
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

        $roles = Role::all();

        return view('admin.users.create', compact('roles'));
    }

    public function store(StoreUser $request)
    {
        $this->can('store-users');

        $user = new User($request->validated());
        $user->password = Hash::make($request->password);

        try {
            if ($request->hasFile('image')) {
                $user->image = $request->image->store('users');
            }

            $user->save();
            $user->roles()->attach($request->role_id);
        } catch (\Exception $e) {
            return redirect()
                ->route('admin.users.index')
                ->withErrors([
                    __('users.store_failure') . $e->getMessage()
                ]);
        }

        return redirect()
            ->route('admin.users.index')
            ->with('message', __('users.store_success'));
    }

    public function edit(int $id)
    {
        $this->can('edit-users');

        $user = User::findOrFail($id);
        $roles = Role::all();

        return view('admin.users.edit', compact('user', 'roles'));
    }

    public function update(UpdateUser $request, int $id)
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

            $user->roles()->detach();
            $user->roles()->attach($request->role_id);
        } catch (\Exception $e) {
            return redirect()
                ->route('admin.users.index')
                ->withErrors([
                    __('users.update_failure') . $e->getMessage()
                ]);
        }

        return redirect()
            ->route('admin.users.index')
            ->with('message', __('users.update_success'));
    }

    public function updatePassword(UpdatePasswordUser $request, int $id)
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
                    __('users.update_password_failure') . $e->getMessage()
                ]);
        }

        return redirect()
            ->route('admin.users.index')
            ->with('message', __('users.update_password_success'));
    }

    public function destroy(DestroyUser $request, int $id)
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
                    __('users.destroy_failure') . $e->getMessage()
                ]);
        }

        return redirect()
        ->route('admin.users.index')
        ->with('message', __('users.destroy_success'));
    }
}

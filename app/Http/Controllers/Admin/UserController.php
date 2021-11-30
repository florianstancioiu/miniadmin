<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Spatie\Permission\Models\Role;
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
        $auth_user = Auth::user();
        $keyword = $request->keyword ?? '';
        $users = User::orderBy('id', 'DESC')
            ->with('roles')
            ->search($keyword)
            ->paginate()
            ->appends(request()->query());

        return view('admin.users.index', compact(
            'users',
            'keyword',
        ));
    }

    public function create()
    {
        $roles = Role::all();

        return view('admin.users.create', compact('roles'));
    }

    public function store(StoreUser $request)
    {
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

    public function edit(User $user)
    {
        $roles = Role::all();

        return view('admin.users.edit', compact('user', 'roles'));
    }

    public function update(UpdateUser $request, User $user)
    {
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

    public function destroy(DestroyUser $request, User $user)
    {
        try {
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

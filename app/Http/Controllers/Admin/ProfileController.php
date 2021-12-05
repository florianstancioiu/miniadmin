<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UpdatePasswordProfile;
use App\Http\Requests\User\UpdateProfile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;

class ProfileController extends Controller
{
    /**
     * Return the showProfile view.
     */
    public function showProfile()
    {
        $this->authorize('view profile');

        $user = Auth::user();
        $roles = Role::all();

        return view('admin.users.profile', compact('user', 'roles'));
    }

    /**
     * Implement the update functionality.
     */
    public function update(UpdateProfile $request)
    {
        $this->authorize('update profile');

        $user = Auth::user();
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
                ->route('admin.users.profile')
                ->withErrors([
                    __('users.update_failure') . $e->getMessage(),
                ]);
        }

        return redirect()
            ->route('admin.users.profile')
            ->with('message', __('users.update_success'));
    }

    /**
     * Implement the update password functionality.
     */
    public function updatePassword(UpdatePasswordProfile $request)
    {
        $this->authorize('password-update profile');

        $user = Auth::user();
        if (Hash::check($request->old_password, $user->password)) {
            $user->password = Hash::make($request->password);
        }

        try {
            $user->save();
        } catch (\Exception $e) {
            return redirect()
                ->route('admin.users.profile')
                ->withErrors([
                    __('users.update_password_failure') . $e->getMessage(),
                ]);
        }

        return redirect()
            ->route('admin.users.profile')
            ->with('message', __('users.update_password_success'));
    }
}

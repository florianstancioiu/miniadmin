<?php

namespace App\Http\Controllers\Admin;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\RoleStore;
use App\Http\Requests\RoleUpdate;
use App\Http\Requests\RoleDestroy;
use App\Http\Controllers\Controller;

class RoleController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->keyword ?? '';
        $roles = Role::orderBy('id', 'DESC')
            ->search($keyword)
            ->paginate()
            ->appends(request()->query());

        $auth_user = Auth::user();
        $can_edit_roles = $auth_user->canUser('edit-roles');
        $can_destroy_roles = $auth_user->canUser('destroy-roles');

        return view('admin.roles.index', compact(
            'roles',
            'keyword',
            'can_edit_roles',
            'can_destroy_roles',
        ));
    }

    public function create()
    {
        $permissions = Permission::all();

        return view('admin.roles.create', compact('permissions'));
    }

    public function store(RoleStore $request)
    {
        $role = new Role($request->validated());

        try {
            $role->save();

            $role->permissions()->attach($request->permissions);
        } catch (\Exception $e) {
            return redirect()
                ->route('admin.roles.index')
                ->withErrors([
                    __('roles.store_failure') . $e->getMessage()
                ]);
        }

        return redirect()
            ->route('admin.roles.index')
            ->with('message', __('roles.store_success'));
    }

    public function edit(int $id)
    {
        $role = Role::findOrFail($id);
        $permissions = Permission::all();
        $selected_permissions = $role->permissions()->get();
        $selected_permissions = $selected_permissions->map(function ($item) {
            return $item->id;
        })->toArray();

        return view('admin.roles.edit', compact(
            'role',
            'permissions',
            'selected_permissions'
        ));
    }

    public function update(RoleUpdate $request, int $id)
    {
        $role = Role::findOrFail($id);
        $role = $role->fill($request->validated());

        try {
            $role->save();

            $role->permissions()->detach();
            $role->permissions()->attach($request->permissions);
        } catch (\Exception $e) {
            return redirect()
                ->route('admin.roles.index')
                ->withErrors([
                    __('roles.update_failure') . $e->getMessage()
                ]);
        }

        return redirect()
            ->route('admin.roles.index')
            ->with('message', __('roles.store_success'));
    }

    public function destroy(RoleDestroy $request, int $id)
    {
        try {
            $role = Role::findOrFail($id);
            $role->delete();
        } catch (\Exception $e) {
            return redirect()
                ->route('admin.roles.index')
                ->withErrors([
                    __('roles.destroy_failure') . $e->getMessage()
                ]);
        }

        return redirect()
            ->route('admin.roles.index')
            ->with('message', __('roles.destroy_success'));
    }
}

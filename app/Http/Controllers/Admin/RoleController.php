<?php

namespace App\Http\Controllers\Admin;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
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
        } catch (\Exception $e) {
            return redirect()
                ->route('admin.roles.index')
                ->withErrors([
                    'An exception was raised while storing the role: ' . $e->getMessage()
                ]);
        }

        return redirect()
            ->route('admin.roles.index')
            ->with('message', 'The role record has been successfully stored');
    }

    public function edit(int $id)
    {
        $role = Role::findOrFail($id);

        return view('admin.roles.edit', compact('role'));
    }

    public function update(RoleUpdate $request, int $id)
    {
        $role = Role::findOrFail($id);
        $role = $role->fill($request->validated());

        try {
            $role->save();
        } catch (\Exception $e) {
            return redirect()
                ->route('admin.roles.index')
                ->withErrors([
                    'An exception was raised while updating the role: ' . $e->getMessage()
                ]);
        }

        return redirect()
            ->route('admin.roles.index')
            ->with('message', 'The role record has been successfully updated');
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
                    'An exception was raised while deleting the role: ' . $e->getMessage()
                ]);
        }

        return redirect()
            ->route('admin.roles.index')
            ->with('message', 'The role record has been successfully deleted');
    }
}

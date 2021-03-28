<?php

namespace App\Http\Controllers\Admin;

use App\Models\Permission;
use Illuminate\Http\Request;
use App\Http\Requests\PermissionStore;
use App\Http\Requests\PermissionUpdate;
use App\Http\Requests\PermissionDestroy;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class PermissionController extends Controller
{
    public function index(Request $request)
    {
        $this->can('list-permissions');

        $keyword = $request->keyword ?? '';
        $permissions = Permission::orderBy('id', 'DESC')
            ->search($keyword)
            ->paginate()
            ->appends(request()->query());

        $auth_user = Auth::user();
        $can_edit_permissions = $auth_user->canUser('edit-permissions');
        $can_destroy_permissions = $auth_user->canUser('destroy-permissions');

        return view('admin.permissions.index', compact(
            'permissions',
            'keyword',
            'can_edit_permissions',
            'can_destroy_permissions',
        ));
    }

    public function create()
    {
        $this->can('create-permissions');

        return view('admin.permissions.create');
    }

    public function store(PermissionStore $request)
    {
        $this->can('store-permissions');

        $permission = new Permission($request->validated());

        try {
            $permission->save();
        } catch (\Exception $e) {
            return redirect()
                ->route('admin.permissions.index')
                ->withErrors([
                    'An exception was raised while storing the permission: ' . $e->getMessage()
                ]);
        }

        return redirect()
            ->route('admin.permissions.index')
            ->with('message', 'The permission record has been successfully stored');
    }

    public function edit(int $id)
    {
        $this->can('edit-permissions');

        $permission = Permission::findOrFail($id);

        return view('admin.permissions.edit', compact('permission'));
    }

    public function update(PermissionUpdate $request, int $id)
    {
        $this->can('update-permissions');

        $permission = Permission::findOrFail($id);
        $permission = $permission->fill($request->validated());

        try {
            $permission->save();
        } catch (\Exception $e) {
            return redirect()
                ->route('admin.permissions.index')
                ->withErrors([
                    'An exception was raised while updating the permission: ' . $e->getMessage()
                ]);
        }

        return redirect()
            ->route('admin.permissions.index')
            ->with('message', 'The permission record has been successfully updated');
    }

    public function destroy(PermissionDestroy $request, int $id)
    {
        $this->can('destroy-permissions');

        try {
            $permission = Permission::findOrFail($id);
            $permission->delete();
        } catch (\Exception $e) {
            return redirect()
                ->route('admin.permissions.index')
                ->withErrors([
                    'An exception was raised while deleting the permission: ' . $e->getMessage()
                ]);
        }

        return redirect()
            ->route('admin.permissions.index')
            ->with('message', 'The permission record has been successfully deleted');
    }
}

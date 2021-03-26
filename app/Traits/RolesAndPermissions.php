<?php

namespace App\Traits;

use App\Models\Role;
use App\Models\Permission;
use App\Models\RolePermission;
use App\Models\UserRole;

trait RolesAndPermissions
{
    use \Staudenmeir\EloquentHasManyDeep\HasRelationships;

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_role');
    }

    public function permissions()
    {
        return $this->hasManyDeep(
            Permission::class,
            [
                UserRole::class,
                RolePermission::class
            ],
            [
                'user_id',  // Foreign key on the "user_role" table.
                'role_id',  // Foreign key on the "role_permission" table.
                'id'        // Foreign key on the "permissions" table.
            ],
        );
    }

    public function hasPermission(string $permission) : bool
    {
        $result = $this->join('user_role', 'users.id', '=', 'user_role.user_id')
            ->join('role_permission', 'user_role.role_id', '=', 'role_permission.role_id')
            ->join('permissions', 'role_permission.permission_id', '=', 'permissions.id')
            ->where('permissions.slug', $permission)
            ->where('users.id', auth()->id())
            ->count();

        return $result === 1;
    }

    public function hasRole($role) : bool
    {
        if (is_string($role)) {
            $role = [ $role ];
        }

        $result = $this->withCount(['roles' => function ($query) use ($role) {
                return $query->whereIn('roles.slug', $role);
            }])
            ->where('users.id', auth()->id())
            ->first();

        return $result->roles_count === 1;
    }
}

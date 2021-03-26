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
               'user_id', // Foreign key on the "user_role" table.
               'role_id',    // Foreign key on the "role_permission" table.
               'id'     // Foreign key on the "permissions" table.
            ],
        );
    }

    public function hasPermission(string $permission)
    {
        $result = $this->withCount(['permissions' => function ($query) use ($permission) {
                $query->where('permissions.slug', $permission);
            }])
            ->where('users.id', auth()->id())
            ->first();

        return $result->permissions_count === 1;
    }
}

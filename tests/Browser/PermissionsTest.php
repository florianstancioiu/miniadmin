<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Storage;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\Permission;
use App\Models\Role;
use App\Models\RolePermission;

class PermissionsTest extends DuskTestCase
{
    /** @test */
    public function see_permissions_in_index()
    {
        $admin_user = $this->admin_user;
        $last_permission = Permission::orderBy('id', 'DESC')->limit(1)->first();

        $this->browse(function (Browser $browser) use ($admin_user, $last_permission) {
            $browser
                ->loginAs($admin_user)
                ->visit(route('admin.permissions.index'))
                ->assertSee(__('permissions.add_new_permission'))
                ->assertSee($last_permission->title)
                ->assertSee($last_permission->id)
                ;
        });
    }

    /** @test */
    public function search_works_as_expected()
    {
        $admin_user = $this->admin_user;
        $last_permission = Permission::orderBy('id', 'DESC')->limit(1)->first();

        $this->browse(function (Browser $browser) use ($admin_user, $last_permission) {
            $browser
                ->loginAs($admin_user)
                ->visit(route('admin.permissions.index'))
                ->assertAttribute('input[name="keyword"]', 'placeholder', __('general.search'))
                ->type('keyword', $last_permission->title)
                ->click('button.btn-search[type="submit"')
                ->assertSee($last_permission->title)
                ;
        });
    }

    /** @test */
    public function delete_works_as_expected()
    {
        $admin_user = $this->admin_user;
        $new_permission = Permission::factory()->create();

        $this->browse(function (Browser $browser) use ($admin_user, $new_permission) {
            $browser
                ->loginAs($admin_user)
                ->visit(route('admin.permissions.index'))
                ->assertSee(__('general.delete'))
                ->assertSee($new_permission->title)
                ->assertSee($new_permission->id)
                ->click('table tr:first-child button.btn-delete')
                ->assertSee(__('partials.success'))
                ->assertDontSee($new_permission->id)
                ;
        });
    }

    /** @test */
    public function edit_works_as_expected()
    {
        $admin_user = $this->admin_user;
        $new_permission = Permission::factory()->create();

        $this->browse(function (Browser $browser) use ($admin_user, $new_permission) {
            $browser
                ->loginAs($admin_user)
                ->visit(route('admin.permissions.index'))
                ->assertSee(__('general.edit'))
                ->assertSee($new_permission->title)
                ->assertSee($new_permission->id)
                ->click('table tr:first-child a.btn-edit')
                ->assertRouteIs('admin.permissions.edit', ['permission' => $new_permission->id])
                ->assertSee(__('permissions.edit_permission'))
                ->type('title', $new_permission->title . ' edited')
                ->type('slug', $new_permission->slug . '_edited')
                ->type('group', $new_permission->group . '_edited')
                ->click('button.btn-edit')
                ->assertRouteIs('admin.permissions.index')
                ->assertSee(__('partials.success'))
                ;
        });

        $latest_permission = Permission::orderBy('id', 'DESC')->limit(1)->first();
        $latest_permission->delete();
    }

    /** @test */
    public function create_works_as_expected()
    {
        $admin_user = $this->admin_user;
        $unsaved_permission = Permission::factory()->make();

        $this->browse(function (Browser $browser) use ($admin_user, $unsaved_permission) {
            $browser
                ->loginAs($admin_user)
                ->visit(route('admin.permissions.index'))
                ->assertSee(__('general.edit'))
                ->click('a.btn-add-new')
                ->assertRouteIs('admin.permissions.create')
                ->assertSee(__('permissions.create_permission'))
                ->type('title', $unsaved_permission->title)
                ->type('slug', $unsaved_permission->slug)
                ->type('group', $unsaved_permission->group)
                ->click('button.btn-create')
                ->assertRouteIs('admin.permissions.index')
                ->assertSee(__('partials.success'))
                ;
        });

        $latest_permission = Permission::orderBy('id', 'DESC')->limit(1)->first();
        $latest_permission->delete();
    }

    /** @test */
    public function admin_sees_protected_buttons()
    {
        $admin_user = $this->admin_user;

        $this->browse(function (Browser $browser) use ($admin_user) {
            $browser
                ->loginAs($admin_user)
                ->visit(route('admin.permissions.index'))
                ->assertSee(__('partials.permissions'))
                ->assertSee(__('permissions.add_new_permission'))
                ->assertSee(__('general.edit'))
                ->assertSee(__('general.delete'))
                ;
        });
    }

    /** @test */
    public function guest_user_is_not_allowed_in_index_route()
    {
        $guest_user = $this->guest_user;

        $this->browse(function (Browser $browser) use ($guest_user) {
            $browser
                ->loginAs($guest_user)
                ->visit(route('admin.permissions.index'))
                ->assertSee('401')
                ;
        });
    }

    /** @test */
    public function guest_user_is_not_allowed_in_create_route()
    {
        $guest_user = $this->guest_user;

        $this->browse(function (Browser $browser) use ($guest_user) {
            $browser
                ->loginAs($guest_user)
                ->visit(route('admin.permissions.create'))
                ->assertSee('401')
                ;
        });
    }

    /** @test */
    public function guest_user_is_not_allowed_in_edit_route()
    {
        $guest_user = $this->guest_user;

        $this->browse(function (Browser $browser) use ($guest_user) {
            $browser
                ->loginAs($guest_user)
                ->visit(route('admin.permissions.edit', ['permission' => 1]))
                ->assertSee('401')
                ;
        });
    }

    /** @test */
    public function super_user_doesnt_sees_protected_buttons()
    {
        $super_user = $this->super_user;

        $permissions_to_toggle = [
            'create-permissions',
            'edit-permissions',
            'update-permissions',
            'destroy-permissions'
        ];
        $this->removeSuperUserPermissions($permissions_to_toggle);

        $this->browse(function (Browser $browser) use ($super_user) {
            $browser
            ->loginAs($super_user)
            ->visit(route('admin.permissions.index'))
            ->assertSee(__('partials.permissions'))
            ->assertDontSee(__('permissions.add_new_permission'))
            ->assertDontSeeIn('td.actions-cell', __('general.edit'))
            ->assertDontSeeIn('td.actions-cell', __('general.delete'))
            ;
        });

        $this->addSuperUserPermissions($permissions_to_toggle);
    }

    private function removeSuperUserPermissions(array $permissions)
    {
        $super_permissions = Permission::whereIn('slug', $permissions)->get();
        $super_role = Role::where('slug', 'super')->first();

        $role_permission_data = [];
        foreach ($super_permissions as $permission) {
            RolePermission::where([
                'permission_id' => $permission->id,
                'role_id' => $super_role->id,
            ])->delete();
        }
    }

    private function addSuperUserPermissions(array $permissions)
    {
        $super_permissions = Permission::whereIn('slug', $permissions)->get();
        $super_role = Role::where('slug', 'super')->first();

        $role_permission_data = [];
        foreach ($super_permissions as $permission) {
            RolePermission::insert([
                'permission_id' => $permission->id,
                'role_id' => $super_role->id,
            ]);
        }
    }
}

<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Storage;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\Role;
use App\Models\Permission;
use App\Models\RolePermission;

class RolesTest extends DuskTestCase
{
    /** @test */
    public function see_roles_in_index()
    {
        $admin_user = $this->admin_user;
        $last_role = Role::orderBy('id', 'DESC')->limit(1)->first();

        $this->browse(function (Browser $browser) use ($admin_user, $last_role) {
            $browser
                ->loginAs($admin_user)
                ->visit(route('admin.roles.index'))
                ->assertSee(__('roles.add_new_role'))
                ->assertSee($last_role->title)
                ->assertSee($last_role->id)
                ;
        });
    }

    /** @test */
    public function search_works_as_expected()
    {
        $admin_user = $this->admin_user;
        $last_role = Role::orderBy('id', 'DESC')->limit(1)->first();

        $this->browse(function (Browser $browser) use ($admin_user, $last_role) {
            $browser
                ->loginAs($admin_user)
                ->visit(route('admin.roles.index'))
                ->assertAttribute('input[name="keyword"]', 'placeholder', __('general.search'))
                ->type('keyword', $last_role->title)
                ->click('button.btn-search[type="submit"')
                ->assertSee($last_role->title)
                ;
        });
    }

    /** @test */
    public function delete_works_as_expected()
    {
        $admin_user = $this->admin_user;
        $new_role = Role::factory()->create();

        $this->browse(function (Browser $browser) use ($admin_user, $new_role) {
            $browser
                ->loginAs($admin_user)
                ->visit(route('admin.roles.index'))
                ->assertSee(__('general.delete'))
                ->assertSee($new_role->title)
                ->assertSee($new_role->id)
                ->click('table tr:first-child button.btn-delete')
                ->assertSee(__('partials.success'))
                ->assertDontSee($new_role->id)
                ;
        });
    }

    /** @test */
    public function edit_works_as_expected()
    {
        $admin_user = $this->admin_user;
        $new_role = Role::factory()->create();

        $this->browse(function (Browser $browser) use ($admin_user, $new_role) {
            $browser
                ->loginAs($admin_user)
                ->visit(route('admin.roles.index'))
                ->assertSee(__('general.edit'))
                ->assertSee($new_role->title)
                ->assertSee($new_role->id)
                ->click('table tr:first-child a.btn-edit')
                ->assertRouteIs('admin.roles.edit', ['role' => $new_role->id])
                ->assertSee(__('roles.edit_role'))
                ->type('title', $new_role->title . ' edited')
                ->type('slug', $new_role->slug . '_edited')
                ->check('input[type="checkbox"]')
                ->click('button.btn-edit')
                ->assertRouteIs('admin.roles.index')
                ->assertSee(__('partials.success'))
                ;
        });

        $latest_role = Role::orderBy('id', 'DESC')->limit(1)->first();
        $latest_role->delete();
    }

    /** @test */
    public function create_works_as_expected()
    {
        $admin_user = $this->admin_user;
        $unsaved_role = Role::factory()->make();

        $this->browse(function (Browser $browser) use ($admin_user, $unsaved_role) {
            $browser
                ->loginAs($admin_user)
                ->visit(route('admin.roles.index'))
                ->assertSee(__('general.edit'))
                ->click('a.btn-add-new')
                ->assertRouteIs('admin.roles.create')
                ->assertSee(__('roles.create_role'))
                ->type('title', $unsaved_role->title)
                ->type('slug', $unsaved_role->slug)
                ->check('input[type="checkbox"]')
                ->click('button.btn-create')
                ->assertRouteIs('admin.roles.index')
                ->assertSee(__('partials.success'))
                ;
        });

        $latest_role = Role::orderBy('id', 'DESC')->limit(1)->first();
        $latest_role->delete();
    }

    /** @test */
    public function admin_sees_protected_buttons()
    {
        $admin_user = $this->admin_user;

        $this->browse(function (Browser $browser) use ($admin_user) {
            $browser
                ->loginAs($admin_user)
                ->visit(route('admin.roles.index'))
                ->assertSee(__('partials.roles'))
                ->assertSee(__('roles.add_new_role'))
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
                ->visit(route('admin.roles.index'))
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
                ->visit(route('admin.roles.create'))
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
                ->visit(route('admin.roles.edit', ['role' => 1]))
                ->assertSee('401')
                ;
        });
    }

    /** @test */
    public function super_user_doesnt_sees_protected_buttons()
    {
        $super_user = $this->super_user;

        $permissions_to_toggle = [
            'create-roles',
            'edit-roles',
            'update-roles',
            'destroy-roles'
        ];
        $this->removeSuperUserPermissions($permissions_to_toggle);

        $this->browse(function (Browser $browser) use ($super_user) {
            $browser
                ->loginAs($super_user)
                ->visit(route('admin.roles.index'))
                ->assertSee(__('partials.roles'))
                ->assertDontSee(__('roles.add_new_role'))
                ->assertDontSee(__('general.edit'))
                ->assertDontSee(__('general.delete'))
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

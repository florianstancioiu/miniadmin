<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Storage;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User;
use App\Models\Permission;
use App\Models\Role;
use App\Models\RolePermission;

class UsersTest extends DuskTestCase
{
    /** @test */
    public function see_users_in_index()
    {
        $admin_user = $this->admin_user;
        $last_user = User::orderBy('id', 'DESC')->limit(1)->first();

        $this->browse(function (Browser $browser) use ($admin_user, $last_user) {
            $browser
                ->loginAs($admin_user)
                ->visit(route('admin.users.index'))
                ->assertSee(__('users.add_new_user'))
                ->assertSee($last_user->full_name)
                ->assertSee($last_user->id)
                ;
        });
    }

    /** @test */
    public function search_works_as_expected()
    {
        $admin_user = $this->admin_user;
        $last_user = User::orderBy('id', 'DESC')->limit(1)->first();

        $this->browse(function (Browser $browser) use ($admin_user, $last_user) {
            $browser
                ->loginAs($admin_user)
                ->visit(route('admin.users.index'))
                ->assertAttribute('input[name="keyword"]', 'placeholder', __('general.search'))
                ->type('keyword', $last_user->first_name)
                ->click('button.btn-search[type="submit"')
                ->assertSee($last_user->first_name)
                ;
        });
    }

    /** @test */
    public function delete_works_as_expected()
    {
        $admin_user = $this->admin_user;
        $new_user = User::factory()->create();

        $this->browse(function (Browser $browser) use ($admin_user, $new_user) {
            $browser
                ->loginAs($admin_user)
                ->visit(route('admin.users.index'))
                ->assertSee(__('general.delete'))
                ->assertSee($new_user->first_name)
                ->assertSee($new_user->id)
                ->click('table tr:first-child button.btn-delete')
                ->click('button.swal2-confirm')
                ->assertSee(__('partials.success'))
                ->assertDontSee($new_user->first_name)
                ;
        });
    }

    /** @test */
    public function edit_works_as_expected()
    {
        $admin_user = $this->admin_user;
        $new_user = User::factory()->create();

        $this->browse(function (Browser $browser) use ($admin_user, $new_user) {
            $browser
                ->loginAs($admin_user)
                ->visit(route('admin.users.index'))
                ->assertSee(__('general.edit'))
                ->assertSee($new_user->first_name)
                ->assertSee($new_user->last_name)
                ->click('table tr:first-child a.btn-edit')
                ->assertRouteIs('admin.users.edit', ['user' => $new_user->id])
                ->assertSee(__('users.edit_user'))
                ->attach('image', storage_path('app/public/testing/test.jpg'))
                ->type('first_name', $new_user->first_name)
                ->type('last_name', $new_user->last_name)
                ->type('email', $new_user->email)
                ->select('role_id', 1)
                ->click('button.btn-edit-user')
                ->assertRouteIs('admin.users.index')
                ->assertSee(__('partials.success'))
                ;
        });

        $latest_user = User::orderBy('id', 'DESC')->limit(1)->first();
        // delete existing image
        Storage::delete($latest_user->image);
        $new_user->delete();
    }

    /** @test */
    public function create_works_as_expected()
    {
        $admin_user = $this->admin_user;
        $unsaved_user = User::factory()->make();

        $this->browse(function (Browser $browser) use ($admin_user, $unsaved_user) {
            $browser
                ->loginAs($admin_user)
                ->visit(route('admin.users.index'))
                ->assertSee(__('general.edit'))
                ->click('a.btn-add-new')
                ->assertRouteIs('admin.users.create')
                ->assertSee(__('users.create_user'))
                ->attach('image', storage_path('app/public/testing/test.jpg'))
                ->type('first_name', $unsaved_user->first_name)
                ->type('last_name', $unsaved_user->last_name)
                ->type('email', $unsaved_user->email)
                ->select('role_id', 1)
                ->type('password', 'password')
                ->type('password_confirmation', 'password')
                ->click('button.btn-create')
                ->assertRouteIs('admin.users.index')
                ->assertSee(__('partials.success'))
                ;
        });

        $latest_user = User::orderBy('id', 'DESC')->limit(1)->first();
        // delete existing image
        Storage::delete($latest_user->image);
        $latest_user->delete();
    }

    /** @test */
    public function admin_sees_protected_buttons()
    {
        $admin_user = $this->admin_user;

        $this->browse(function (Browser $browser) use ($admin_user) {
            $browser
                ->loginAs($admin_user)
                ->visit(route('admin.users.index'))
                ->assertSee(__('partials.users'))
                ->assertSee(__('users.add_new_user'))
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
                ->visit(route('admin.users.index'))
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
                ->visit(route('admin.users.create'))
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
                ->visit(route('admin.users.edit', ['user' => 1]))
                ->assertSee('401')
                ;
        });
    }

    /** @test */
    public function super_user_doesnt_sees_protected_buttons()
    {
        $super_user = $this->super_user;

        // Add list-users permissions for the super role
        $permissions_to_toggle = [
            'list-users',
        ];

        $this->addSuperUserPermissions($permissions_to_toggle);

        $this->browse(function (Browser $browser) use ($super_user) {
            $browser
                ->loginAs($super_user)
                ->visit(route('admin.users.index'))
                ->assertSee(__('partials.users'))
                ->assertDontSee(__('users.add_new_user'))
                ->assertDontSee(__('general.edit'))
                ->assertDontSee(__('general.delete'))
                ;
        });

        $this->removeSuperUserPermissions($permissions_to_toggle);
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

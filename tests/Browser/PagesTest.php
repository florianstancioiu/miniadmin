<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Storage;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\Page;
use App\Models\Permission;
use App\Models\Role;
use App\Models\RolePermission;

class PagesTest extends DuskTestCase
{
    /** @test */
    public function see_pages_in_index()
    {
        $admin_user = $this->admin_user;
        $last_page = Page::orderBy('id', 'DESC')->limit(1)->first();

        $this->browse(function (Browser $browser) use ($admin_user, $last_page) {
            $browser
                ->loginAs($admin_user)
                ->visit(route('admin.pages.index'))
                ->assertSee(__('pages.add_new_page'))
                ->assertSee($last_page->title)
                ->assertSee($last_page->id)
                ;
        });
    }

    /** @test */
    public function search_works_as_expected()
    {
        $admin_user = $this->admin_user;
        $last_page = Page::orderBy('id', 'DESC')->limit(1)->first();

        $this->browse(function (Browser $browser) use ($admin_user, $last_page) {
            $browser
                ->loginAs($admin_user)
                ->visit(route('admin.pages.index'))
                ->assertAttribute('input[name="keyword"]', 'placeholder', __('general.search'))
                ->type('keyword', $last_page->title)
                ->click('button.btn-search[type="submit"')
                ->assertSee($last_page->title)
                ;
        });
    }

    /** @test */
    public function delete_works_as_expected()
    {
        $admin_user = $this->admin_user;
        $new_page = Page::factory()->create();

        $this->browse(function (Browser $browser) use ($admin_user, $new_page) {
            $browser
                ->loginAs($admin_user)
                ->visit(route('admin.pages.index'))
                ->assertSee(__('general.delete'))
                ->assertSee($new_page->title)
                ->assertSee($new_page->id)
                ->click('table tr:first-child button.btn-delete')
                ->assertSee(__('partials.success'))
                ->assertDontSee($new_page->id)
                ;
        });
    }

    /** @test */
    public function edit_works_as_expected()
    {
        $admin_user = $this->admin_user;
        $new_page = Page::factory()->create();

        $this->browse(function (Browser $browser) use ($admin_user, $new_page) {
            $browser
                ->loginAs($admin_user)
                ->visit(route('admin.pages.index'))
                ->assertSee(__('general.edit'))
                ->assertSee($new_page->title)
                ->assertSee($new_page->id)
                ->click('table tr:first-child a.btn-edit')
                ->assertRouteIs('admin.pages.edit', ['page' => $new_page->id])
                ->assertSee(__('pages.edit_page'))
                ->assertValue('#form-title', $new_page->title)
                ->attach('image', storage_path('app/public/testing/test.jpg'))
                ->assertValue('#form-content', $new_page->content)
                ->type('title', $new_page->title . ' edited')
                ->type('content', $new_page->content . ' edited')
                ->click('button.btn-edit')
                ->assertRouteIs('admin.pages.index')
                ->assertSee(__('partials.success'))
                ;
        });

        $latest_page = Page::orderBy('id', 'DESC')->limit(1)->first();
        // delete existing image
        Storage::delete($latest_page->image);
        $new_page->delete();
    }

    /** @test */
    public function create_works_as_expected()
    {
        $admin_user = $this->admin_user;
        $unsaved_page = Page::factory()->make();

        $this->browse(function (Browser $browser) use ($admin_user, $unsaved_page) {
            $browser
                ->loginAs($admin_user)
                ->visit(route('admin.pages.index'))
                ->assertSee(__('general.edit'))
                ->click('a.btn-add-new')
                ->assertRouteIs('admin.pages.create')
                ->assertSee(__('pages.create_page'))
                ->type('title', $unsaved_page->title)
                ->attach('image', storage_path('app/public/testing/test.jpg'))
                ->type('content', $unsaved_page->content)
                ->click('button.btn-create')
                ->assertRouteIs('admin.pages.index')
                ->assertSee(__('partials.success'))
                ;
        });

        $latest_page = Page::orderBy('id', 'DESC')->limit(1)->first();
        // delete existing image
        Storage::delete($latest_page->image);
        $latest_page->delete();
    }

    /** @test */
    public function admin_sees_protected_buttons()
    {
        $admin_user = $this->admin_user;

        $this->browse(function (Browser $browser) use ($admin_user) {
            $browser
                ->loginAs($admin_user)
                ->visit(route('admin.pages.index'))
                ->assertSee(__('partials.pages'))
                ->assertSee(__('pages.add_new_page'))
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
                ->visit(route('admin.pages.index'))
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
                ->visit(route('admin.pages.create'))
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
                ->visit(route('admin.pages.edit', ['page' => 1]))
                ->assertSee('401')
                ;
        });
    }

    /** @test */
    public function super_user_doesnt_sees_protected_buttons()
    {
        $super_user = $this->super_user;

        // Add list-pages permissions for the super role
        $new_permissions = [
            'list-pages',
        ];
        $super_permissions = Permission::whereIn('slug', $new_permissions)->get();
        $super_role = Role::where('slug', 'super')->first();
        $role_permission_data = [];
        foreach ($super_permissions as $permission) {
            $role_permission_data[] = [
                'permission_id' => $permission->id,
                'role_id' => $super_role->id,
            ];
        }
        RolePermission::insert($role_permission_data);

        $this->browse(function (Browser $browser) use ($super_user) {
            $browser
                ->loginAs($super_user)
                ->visit(route('admin.pages.index'))
                ->assertSee(__('partials.pages'))
                ->assertDontSee(__('pages.add_new_page'))
                ->assertDontSee(__('general.edit'))
                ->assertDontSee(__('general.delete'))
                ;
        });

        RolePermission::where([
            'role_id' => $super_role->id,
            'permission_id' => Permission::where('slug', 'list-pages')->first()->id
        ])->delete();
    }
}

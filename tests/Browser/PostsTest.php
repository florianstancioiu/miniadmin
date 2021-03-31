<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Storage;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\Post;
use App\Models\Permission;
use App\Models\Role;
use App\Models\RolePermission;

class PostsTest extends DuskTestCase
{
    /** @test */
    public function see_posts_in_index()
    {
        $admin_user = $this->admin_user;
        $last_post = Post::orderBy('id', 'DESC')->limit(1)->first();

        $this->browse(function (Browser $browser) use ($admin_user, $last_post) {
            $browser
                ->loginAs($admin_user)
                ->visit(route('admin.posts.index'))
                ->assertSee(__('posts.add_new_post'))
                ->assertSee($last_post->title)
                ->assertSee($last_post->id)
                ;
        });
    }

    /** @test */
    public function search_works_as_expected()
    {
        $admin_user = $this->admin_user;
        $last_post = Post::orderBy('id', 'DESC')->limit(1)->first();

        $this->browse(function (Browser $browser) use ($admin_user, $last_post) {
            $browser
                ->loginAs($admin_user)
                ->visit(route('admin.posts.index'))
                ->assertAttribute('input[name="keyword"]', 'placeholder', __('general.search'))
                ->type('keyword', $last_post->title)
                ->click('button.btn-search[type="submit"')
                ->assertSee($last_post->title)
                ;
        });
    }

    /** @test */
    public function delete_works_as_expected()
    {
        $admin_user = $this->admin_user;
        $new_post = Post::factory()->create();

        $this->browse(function (Browser $browser) use ($admin_user, $new_post) {
            $browser
                ->loginAs($admin_user)
                ->visit(route('admin.posts.index'))
                ->assertSee(__('general.delete'))
                ->assertSee($new_post->title)
                ->assertSee($new_post->id)
                ->click('table tr:first-child button.btn-delete')
                ->click('button.swal2-confirm')
                ->assertSee(__('partials.success'))
                ->assertDontSee($new_post->id)
                ;
        });
    }

    /** @test */
    public function edit_works_as_expected()
    {
        $admin_user = $this->admin_user;
        $new_post = Post::factory()->create();

        $this->browse(function (Browser $browser) use ($admin_user, $new_post) {
            $browser
                ->loginAs($admin_user)
                ->visit(route('admin.posts.index'))
                ->assertSee(__('general.edit'))
                ->assertSee($new_post->title)
                ->assertSee($new_post->id)
                ->click('table tr:first-child a.btn-edit')
                ->assertRouteIs('admin.posts.edit', ['post' => $new_post->id])
                ->assertSee(__('posts.edit_post'))
                ->assertValue('#form-title', $new_post->title)
                ->attach('image', storage_path('app/public/testing/test.jpg'))
                ->assertValue('#form-content', $new_post->content)
                ->type('title', $new_post->title . ' edited')
                ->type('content', $new_post->content . ' edited')
                ->click('button.btn-edit')
                ->assertRouteIs('admin.posts.index')
                ->assertSee(__('partials.success'))
                ;
        });

        $latest_post = Post::orderBy('id', 'DESC')->limit(1)->first();
        // delete existing image
        Storage::delete($latest_post->image);
        $new_post->delete();
    }

    /** @test */
    public function create_works_as_expected()
    {
        $admin_user = $this->admin_user;
        $unsaved_post = Post::factory()->make();

        $this->browse(function (Browser $browser) use ($admin_user, $unsaved_post) {
            $browser
                ->loginAs($admin_user)
                ->visit(route('admin.posts.index'))
                ->assertSee(__('general.edit'))
                ->click('a.btn-add-new')
                ->assertRouteIs('admin.posts.create')
                ->assertSee(__('posts.create_post'))
                ->type('title', $unsaved_post->title)
                ->attach('image', storage_path('app/public/testing/test.jpg'))
                ->type('content', $unsaved_post->content)
                ->click('button.btn-create')
                ->assertRouteIs('admin.posts.index')
                ->assertSee(__('partials.success'))
                ;
        });

        $latest_post = Post::orderBy('id', 'DESC')->limit(1)->first();
        // delete existing image
        Storage::delete($latest_post->image);
        $latest_post->delete();
    }

    /** @test */
    public function admin_sees_protected_buttons()
    {
        $admin_user = $this->admin_user;

        $this->browse(function (Browser $browser) use ($admin_user) {
            $browser
                ->loginAs($admin_user)
                ->visit(route('admin.posts.index'))
                ->assertSee(__('partials.posts'))
                ->assertSee(__('posts.add_new_post'))
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
                ->visit(route('admin.posts.index'))
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
                ->visit(route('admin.posts.create'))
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
                ->visit(route('admin.posts.edit', ['post' => 1]))
                ->assertSee('401')
                ;
        });
    }

    /** @test */
    public function super_user_doesnt_sees_protected_buttons()
    {
        $super_user = $this->super_user;

        $permissions_to_toggle = [
            'create-posts',
            'edit-posts',
            'update-posts',
            'destroy-posts'
        ];
        $this->removeSuperUserPermissions($permissions_to_toggle);

        $this->browse(function (Browser $browser) use ($super_user) {
            $browser
                ->loginAs($super_user)
                ->visit(route('admin.posts.index'))
                ->assertSee(__('partials.posts'))
                ->assertDontSee(__('posts.add_new_post'))
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

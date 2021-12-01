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
                ->assertSee(__('general.add_new'))
                ->assertSee($last_post->title)
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
                ->assertAttribute('.btn-delete', 'title', __('general.delete'))
                ->assertSee($new_post->title)
                ->click('table tr:first-child button.btn-delete')
                ->click('button.swal2-confirm')
                ->assertSee(__('partials.success'))
                ->assertDontSee($new_post->title)
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
                ->assertAttribute('.btn-edit', 'title', __('general.edit'))
                ->assertSee($new_post->title)
                ->click('table tr:first-child a.btn-edit')
                ->assertRouteIs('admin.posts.edit', ['post' => $new_post->id])
                ->assertSee(__('posts.edit_post'))
                ->assertValue('#form-title', $new_post->title)
                ->attach('image', storage_path('app/public/testing/test.jpg'))
                ->assertValue('#form-content', $new_post->content)
                ->type('title', $new_post->title . ' edited')
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
                ->click('a.btn-add-new')
                ->assertRouteIs('admin.posts.create')
                ->assertSee(__('posts.create_post'))
                ->type('title', $unsaved_post->title);

            $browser->script('window.SimpleMDEInstance.value("testing")');

            $browser
                ->attach('image', storage_path('app/public/testing/test.jpg'))
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
                ->assertSee(__('general.add_new'))
                ->assertAttribute('.btn-edit', 'title', __('general.edit'))
                ->assertAttribute('.btn-delete', 'title', __('general.delete'))
                ;
        });
    }
}

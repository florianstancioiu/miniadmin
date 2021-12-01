<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Storage;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\Page;

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
                ->assertSee(__('general.add_new'))
                ->assertSee($last_page->title)
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
                ->assertAttribute('.btn-delete', 'title', __('general.delete'))
                ->assertSee($new_page->title)
                ->click('table tr:first-child button.btn-delete')
                ->click('button.swal2-confirm')
                ->assertSee(__('partials.success'))
                ->assertDontSee($new_page->title)
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
                ->assertAttribute('.btn-edit', 'title', __('general.edit'))
                ->assertSee($new_page->title)
                ->click('table tr:first-child a.btn-edit')
                ->assertRouteIs('admin.pages.edit', ['page' => $new_page->id])
                ->assertSee(__('pages.edit_page'))
                ->assertValue('#form-title', $new_page->title)
                ->attach('image', storage_path('app/public/testing/test.jpg'))
                ->assertValue('#form-content', $new_page->content)
                ->type('title', $new_page->title . ' edited')
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
                ->click('a.btn-add-new')
                ->assertRouteIs('admin.pages.create')
                ->assertSee(__('pages.create_page'))
                ->type('title', $unsaved_page->title);

            $browser->script('window.SimpleMDEInstance.value("testing")');

            $browser
                ->attach('image', storage_path('app/public/testing/test.jpg'))
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
                ->assertSee(__('general.add_new'))
                ->assertAttribute('.btn-edit', 'title', __('general.edit'))
                ->assertAttribute('.btn-delete', 'title', __('general.delete'))
                ;
        });
    }
}

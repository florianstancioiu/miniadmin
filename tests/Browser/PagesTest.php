<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Storage;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\Page;
use App\Models\User;

class PagesTest extends DuskTestCase
{
    protected $admin_user;

    protected $super_user;

    protected $guest_user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin_user = User::find(1)->first();
        $this->super_user = User::find(2)->first();
        $this->guest_user = User::find(3)->first();
    }


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
}

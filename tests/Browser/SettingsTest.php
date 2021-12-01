<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Storage;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\Setting;
use App\Models\Role;
use App\Models\Permission;
use App\Models\RolePermission;

class SettingsTest extends DuskTestCase
{
    /** @test */
    public function edit_works_as_expected()
    {
        $admin_user = $this->admin_user;

        $text_setting = Setting::factory()->create(['type' => 'text']);
        $textarea_setting = Setting::factory()->create(['type' => 'textarea']);
        $image_setting = Setting::factory()->create(['type' => 'image']);

        $this->browse(function (Browser $browser)
        use ( $admin_user, $text_setting, $textarea_setting, $image_setting ) {
            $browser
                ->loginAs($admin_user)
                ->visit(route('admin.settings.index'))
                ->assertSee(__('general.save'))
                ->type('#input-' . $text_setting->key, $text_setting->value . '_edited')
                ->type('#input-' . $textarea_setting->key, $textarea_setting->value . '_edited')
                ->attach('#input-' . $textarea_setting->key, storage_path('app/public/testing/test.jpg'))
                ->click('button.btn-save')
                ->assertRouteIs('admin.settings.index')
                ->assertSee(__('partials.success'))
                ;
        });

        $text_setting->delete();
        $textarea_setting->delete();
        $image_setting = Setting::orderBy('id', 'DESC')->where('type', 'image')->first();
        Storage::delete($image_setting->value);
        $image_setting->delete();
    }

    /** @test */
    public function super_user_sees_menu_entry()
    {
        $super_user = $this->super_user;

        $this->browse(function (Browser $browser) use ($super_user) {
            $browser
                ->loginAs($super_user)
                ->visit(route('admin.settings.index'))
                ->assertSeeIn('ul.nav', __('partials.settings'))
                ;
        });
    }

    /** @test */
    public function guest_user_doesnt_sees_menu_entry()
    {
        $guest_user = $this->guest_user;

        $this->browse(function (Browser $browser) use ($guest_user) {
            $browser
                ->loginAs($guest_user)
                ->visit(route('admin.settings.index'))
                ->assertSee('403')
                ;
        });
    }
}

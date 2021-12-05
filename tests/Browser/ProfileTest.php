<?php

namespace Tests\Browser;

use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ProfileTest extends DuskTestCase
{
    /** @test */
    public function guest_user_can_edit_profile()
    {
        $guest_user = $this->guest_user;
        $new_user = User::factory()->make([
            'email' => 'makeSureEmailDoesntExistInDB@example.com'
        ]);

        $this->browse(function (Browser $browser) use ($guest_user, $new_user) {
            $browser
                ->loginAs($guest_user)
                ->visit(route('admin.users.profile'))
                ->attach('image', storage_path('app/public/testing/test.jpg'))
                ->type('first_name', $new_user->first_name)
                ->type('last_name', $new_user->last_name)
                ->click('button.btn-edit-user')
                ->assertRouteIs('admin.users.profile')
                ->assertSee(__('partials.success'))
                ->assertSee($new_user->first_name)
                ->assertSee($new_user->last_name);
        });
    }

    /** @test */
    public function guest_user_is_allowed_in_profile()
    {
        $guest_user = $this->guest_user;

        $this->browse(function (Browser $browser) use ($guest_user) {
            $browser
                ->loginAs($guest_user)
                ->visit(route('admin.users.profile'))
                ->assertSee(__('users.edit_profile'));
        });
    }
}

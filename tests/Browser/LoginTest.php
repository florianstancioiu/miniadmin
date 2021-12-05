<?php

namespace Tests\Browser;

use App\Models\User;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class LoginTest extends DuskTestCase
{
    /** @test */
    public function redirect_user_to_login()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin')
                    ->assertSee(__('auth.sign_in_to_start_session'));
        });
    }

    /** @test */
    public function login_as_admin()
    {
        $user = User::find(1);

        $this->browse(function (Browser $browser) use ($user) {
            $browser->visit('/login')
                    ->type('email', $user->email)
                    ->type('password', 'password')
                    ->press('button.btn-primary')
                    ->assertPathIs('/admin');
        });
    }

    // TODO: fail to login
}

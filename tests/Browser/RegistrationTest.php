<?php

namespace Tests\Browser;

use App\Models\User;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class RegistrationTest extends DuskTestCase
{
    /** @test */
    public function registration_process()
    {
        $user = User::factory()->make();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->visit('/register')
                ->type('first_name', $user->first_name)
                ->type('last_name', $user->last_name)
                ->type('email', $user->email)
                ->type('password', 'password')
                ->type('password_confirmation', 'password')
                ->press('button.btn-primary')
                ->assertPathIs('/home');
        });

        $user = User::orderBy('id', 'DESC')->first();
        $user->delete();
    }

    // TODO: Fail to register
}

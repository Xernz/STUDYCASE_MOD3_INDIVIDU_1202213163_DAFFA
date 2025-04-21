<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class RegisterTest extends DuskTestCase
{
    /**
     * Test user registration process.
     */
    public function testUserCanRegister(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/register')
                    ->type('name', 'Test User')
                    ->type('email', 'testuser'.time().'@example.com')
                    ->type('password', 'password')
                    ->type('password_confirmation', 'password')
                    ->press('@register-button')
                    ->assertPathIs('/dashboard')
                    ->assertSee("You're logged in!");
        });
    }
}

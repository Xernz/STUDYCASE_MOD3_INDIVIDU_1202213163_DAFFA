<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User;

class LoginTest extends DuskTestCase
{
    /**
     * Test user login process.
     * @group login
     */
    public function testUserCanLogin(): void
    {
        // Ensure no duplicate user exists
        User::where('email', 'testuser1@example.com')->delete();

        // Now create the user
        User::factory()->create([
            'email' => 'testuser1@example.com',
            'password' => bcrypt('password'),
        ]);

        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                ->type('email', 'testuser1@example.com')
                ->type('password', 'password')
                ->press('@login-button')
                ->assertPathIs('/dashboard')
                ->assertSee("You're logged in!");
        });
    }
}

<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User;

class LogoutTest extends DuskTestCase
{
    /**
     * Test logging out as a logged-in user.
     *
     */
    public function testUserCanLogout(): void
    {
        // Ensure the user exists and is fresh
        User::where('email', 'testuser_logout@example.com')->delete();
        $user = User::factory()->create([
            'email' => 'testuser_logout@example.com',
            'password' => bcrypt('password'),
        ]);
        sleep(1); // Ensure the user is committed before browser interaction

        // Debug: Assert user exists before proceeding
        $this->assertDatabaseHas('users', [
            'email' => $user->email,
        ]);

        $this->browse(function (Browser $browser) use ($user) {
            // Login
            $browser->visit('/login')
                ->type('email', $user->email)
                ->type('password', 'password')
                ->press('@login-button')
                ->assertPathIs('/dashboard')
                // Open the navigation dropdown if needed
                ->screenshot('logouttest-before-dropdown')
                ->click('.inline-flex.items-center.px-3')
                ->pause(300)
                // Logout using navigation menu
                ->screenshot('logouttest-before-logout')
                ->click('@logout-link')
                // Wait for any page change after logout (login or home)
                ->pause(1000)
                // Debug: Take screenshot to inspect logout result
                ->screenshot('logouttest-after-logout');
        });
    }
}

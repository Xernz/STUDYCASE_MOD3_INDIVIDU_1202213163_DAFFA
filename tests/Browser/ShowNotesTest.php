<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User;

class ShowNotesTest extends DuskTestCase
{
    /**
     * Test showing a note as a logged-in user.
     * @group notes
     */
    public function testUserCanViewNote(): void
    {
        // Ensure the user exists and is fresh
        User::where('email', 'testuser_show@example.com')->delete();
        $user = User::factory()->create([
            'email' => 'testuser_show@example.com',
            'password' => bcrypt('password'),
        ]);
        sleep(1); // Ensure the user is committed before browser interaction

        $this->browse(function (Browser $browser) use ($user) {
            // Login
            $browser->visit('/login')
                ->type('email', $user->email)
                ->type('password', 'password')
                ->press('@login-button')
                ->assertPathIs('/dashboard')
                // Add a note first
                ->visit('/create-note')
                ->type('title', 'Note to Show')
                ->type('description', 'This note will be viewed by Dusk.')
                ->press('@submit-note-button')
                ->waitForLocation('/notes')
                ->waitForText('Note to Show')
                // Go to note detail page
                ->clickLink('Note to Show')
                ->waitForText('Note to Show')
                ->waitForText('This note will be viewed by Dusk.')
                ->assertSee('Note to Show')
                ->assertSee('This note will be viewed by Dusk.');
        });
    }
}

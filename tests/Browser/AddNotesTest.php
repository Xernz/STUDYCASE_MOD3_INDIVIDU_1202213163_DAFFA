<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User;

class AddNotesTest extends DuskTestCase
{
    /**
     * Test adding a new note as a logged-in user.
     * @group notes
     */
    public function testUserCanAddNote(): void
    {
        // Ensure the user exists and is fresh
        User::where('email', 'testuser1@example.com')->delete();
        $user = User::factory()->create([
            'email' => 'testuser1@example.com',
            'password' => bcrypt('password'),
        ]);
        sleep(1); // Ensure the user is committed before browser interaction

        $this->browse(function (Browser $browser) use ($user) {
            $browser->visit('/login')
                ->type('email', $user->email)
                ->type('password', 'password')
                ->press('@login-button')
                ->assertPathIs('/dashboard')
                ->visit('/create-note')
                ->type('title', 'Test Note Title')
                ->type('description', 'This is a test note created by Dusk.')
                ->press('@submit-note-button')
                ->waitForLocation('/notes')
                ->waitForText('Test Note Title')
                ->assertPathIs('/notes')
                ->assertSee('Test Note Title');
        });
    }
}

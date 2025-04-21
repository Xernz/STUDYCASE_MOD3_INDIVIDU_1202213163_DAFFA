<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User;

class DeleteNotesTest extends DuskTestCase
{
    /**
     * Test deleting a note as a logged-in user.
     * @group notes
     */
    public function testUserCanDeleteNote(): void
    {
        // Ensure the user exists and is fresh
        User::where('email', 'testuser_delete@example.com')->delete();
        $user = User::factory()->create([
            'email' => 'testuser_delete@example.com',
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
                ->type('title', 'Note to Delete')
                ->type('description', 'This note will be deleted by Dusk.')
                ->press('@submit-note-button')
                ->waitForLocation('/notes')
                ->waitForText('Note to Delete')
                // Go to note detail page
                ->clickLink('Note to Delete')
                ->waitFor('@delete-note-button')
                ->press('@delete-note-button')
                ->waitForLocation('/notes')
                ->pause(500)
                ->assertDontSee('Note to Delete');
        });
    }
}

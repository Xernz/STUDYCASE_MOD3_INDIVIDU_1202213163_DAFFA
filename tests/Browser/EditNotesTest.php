<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User;

class EditNotesTest extends DuskTestCase
{
    /**
     * Test editing an existing note as a logged-in user.
     * @group notes
     */
    public function testUserCanEditNote(): void
    {
        // Ensure the user exists and is fresh
        User::where('email', 'testuser_edit@example.com')->delete();
        $user = User::factory()->create([
            'email' => 'testuser_edit@example.com',
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
                ->type('title', 'Note to Edit')
                ->type('description', 'This note will be edited by Dusk.')
                ->press('@submit-note-button')
                ->waitForLocation('/notes')
                ->waitForText('Note to Edit')
                // Go to note detail page
                ->clickLink('Note to Edit')
                ->waitFor('@edit-note-link')
                ->click('@edit-note-link')
                ->waitFor('@update-note-button')
                ->type('title', 'Note Edited by Dusk')
                ->type('description', 'This note has been edited by Dusk.')
                ->press('@update-note-button')
                ->waitForLocation('/notes')
                ->waitForText('Note Edited by Dusk')
                ->assertSee('Note Edited by Dusk');
        });
    }
}

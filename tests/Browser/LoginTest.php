<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class LoginTest extends DuskTestCase
{

    public function testWrongPassword()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                    ->type('email', 'niilo.kurki@hotmail.fi')
                    ->type('password', 'sal')
                    ->press('Kirjaudu')
                    ->assertSee('Kirjautuminen epäonnistui.');
        });
    }
    public function testLoginForm()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                    ->type('email', 'niilo.kurki@hotmail.fi')
                    ->type('password', 'salasana')
                    ->press('Kirjaudu')
                    ->assertPathIs('/home')
                    ->logout();
        });
    }
}

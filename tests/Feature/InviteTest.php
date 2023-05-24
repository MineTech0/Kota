<?php

namespace Tests\Feature;

use App\Invite;
use App\User;
use Tests\TestCase;
use App\Mail\InviteCreated;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class InviteTest extends TestCase
{
    use RefreshDatabase;
    
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_new_invitation()
    {
        Mail::fake();

        $user = User::factory()->create();
        $user->givePermissionTo('access_management');

        $email = 'MOikka6@moi.fi';
        $response = $this
            ->actingAs($user)
            ->call(
                'POST',
                route('store.invite'),
                [
                    "emails" => [
                        0 => $email,
                    ]
                ]
            );
        $response->assertSessionDoesntHaveErrors();
        $user->delete();

        // Assert a message was sent to the given users...
        Mail::assertSent(InviteCreated::class, function ($mail) use ($email) {
            return $mail->hasTo($email);
        });
    }

    public function test_invited_user_can_register()
    {
        $invite = Invite::factory()->create();

        $response = $this->get($invite->url);
        $response->assertStatus(200);


        $response = $this->post(route('register'), [
            'name' => 'Testi',
            'email' => $invite->email,
            'password' => 'password',
            'password_confirmation' => 'password',
            'token' => $invite->token,
        ]);
        
        $this->assertAuthenticated();
        $response->assertRedirect(route('home'));

        $this->assertDatabaseHas('users', [
            'email' => $invite->email,
        ]);

    }

    public function test_non_invited_user_cannot_register()
    {
        $response = $this->get(route('create.user', ['token' => 'invalid']));
        $response->assertStatus(403);

        $response = $this->post(route('register'), [
            'name' => 'Testi',
            'email' => 'test@email.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'token' => 'invalid',
        ]);
        $response->assertSessionHasErrors(['token']);

        $this->assertDatabaseMissing('users', [
            'email' => 'test@email.com'
        ]);

    }

    public function test_invite_can_only_be_used_once()
    {
        $invite = Invite::factory()->create();

        $response = $this->get($invite->url);
        $response->assertStatus(200);

        $response = $this->post(route('register'), [
            'name' => 'Testi',
            'email' => $invite->email,
            'password' => 'password',
            'password_confirmation' => 'password',
            'token' => $invite->token,
        ]);
        
        $this->assertAuthenticated();
        $response->assertRedirect(route('home'));

        $this->assertDatabaseHas('users', [
            'email' => $invite->email,
        ]);

        $response = $this->get($invite->url);
        $response->assertStatus(404);
    }
}

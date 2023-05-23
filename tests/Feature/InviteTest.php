<?php

namespace Tests\Feature;

use App\Invite;
use App\User;
use Tests\TestCase;
use Tests\RefreshTable;
use App\Mail\InviteCreated;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class InviteTest extends TestCase
{
    use RefreshDatabase;
    
    public function createInvite()
    {
        $this->RefreshTable('invites');
        Mail::fake();

        $user = User::factory()->create();
        $user->givePermissionTo('access_management');

        $email = 'test@email.com';
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

        return Invite::where('email', $email)->first();
    }
    
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
        $invite = $this->createInvite();

        $response = $this->get($invite->url);
        $response->assertStatus(200);

        $response = $this->post(route('register'), [
            'name' => 'Testi',
            'email' => $invite->email,
            'password' => 'password',
            'password_confirmation' => 'password',
            'token' => $invite->token,
        ]);

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

        $response->assertStatus(403);

    }
}

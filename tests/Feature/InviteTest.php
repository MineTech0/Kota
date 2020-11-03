<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Tests\RefreshTable;
use App\Mail\InviteCreated;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class InviteTest extends TestCase
{
    use RefreshTable;
    
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_new_invitation()
    {
        $this->RefreshTable('invites');
        Mail::fake();

        $user = factory(User::class)->create();
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
}

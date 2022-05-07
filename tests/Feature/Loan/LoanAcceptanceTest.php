<?php

namespace Tests\Feature;

use App\Mail\LoanAccepted;
use App\Mail\LoanRejected;
use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Mail;
use Tests\LoanHelper;
use Tests\TestCase;

class LoanAcceptanceTest extends TestCase
{
    use DatabaseTransactions;
   
    public function test_accepting_own_loan_gives_error()
    {
        $loanUser = User::factory()->create();
        $loan = LoanHelper::createLoan($loanUser, true);
        $loanUser->givePermissionTo('access_management');

        $response = $this
        ->actingAs($loanUser)
        ->call(
          'PATCH',
          '/loan/'. $loan->id,
          [
            "state" => 2,
          ]
        );
      $response->assertStatus(401)->assertSee('Omaa lainaa ei voi hyväksyä');
    }

    public function test_loan_can_be_accepted_with_mangament_role()
    {
        Mail::fake();
        $loanUser = User::factory()->create();
        $loan = LoanHelper::createLoan($loanUser, true);
        
        $acceptorUser = User::factory()->create();
        $acceptorUser->givePermissionTo('access_management');

        $response = $this
        ->actingAs($acceptorUser)
        ->call(
          'PATCH',
          '/loan/'. $loan->id,
          [
            "state" => 2,
          ]
        );
      $response->assertStatus(200)->assertSee('Lainan hyväksyminen onnistui');
      // Assert a message was sent to the given users...
      Mail::assertSent(LoanAccepted::class, function ($mail) use ($loanUser) {
        return $mail->hasTo($loanUser->email);
    });
    }

    public function test_loan_can_be_rejected_with_mangament_role()
    {
        Mail::fake();
        $loanUser = User::factory()->create();
        $loan = LoanHelper::createLoan($loanUser, true);

        $acceptorUser = User::factory()->create();
        $acceptorUser->givePermissionTo('access_management');

        $response = $this
        ->actingAs($acceptorUser)
        ->call(
          'PATCH',
          '/loan/'. $loan->id,
          [
            "state" => 2,
          ]
        );
      $response->assertStatus(200)->assertSee('Lainan hylkääminen onnistui');
      // Assert a message was sent to the given users...
      Mail::assertSent(LoanRejected::class, function ($mail) use ($loanUser) {
        return $mail->hasTo($loanUser->email);
    });
    }
}

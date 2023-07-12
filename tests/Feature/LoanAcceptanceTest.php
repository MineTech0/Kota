<?php

namespace Tests\Feature;

use App\Equipment;
use App\Loan;
use App\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoanAcceptanceTest extends TestCase
{
    use RefreshDatabase;
   
    public function createOwnLoan()
    {
        $this->testEquipment  = Equipment::factory()->create();
        $this->user = User::factory()->create();

        return Loan::create([
          'user_id'=> $this->user->id,
          'desc'=> 'Desc',
          'reason'=> 'Omaan käyttöön',
          'loan_date'=> Carbon::today() ,
          'return_date'=>Carbon::today()->addDay(7) ,
          'quantity'=>$this->testEquipment->quantity ,
          'equipment_id'=> $this->testEquipment->id,
          'state'=> 1,
          ]);
    }
    public function test_accepting_own_loan_gives_error()
    {
        $loan = $this->createOwnLoan();
        $this->user->givePermissionTo('accept_loan');

        $response = $this
        ->actingAs($this->user)
        ->call(
          'PATCH',
          '/loan/'. $loan->id,
          [
            "state" => 2,
          ]
        );
      $response->assertStatus(401)->assertSee('Omaa lainaa ei voi hyväksyä');
    }
}

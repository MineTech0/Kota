<?php

namespace Tests\Feature;

use App\Equipment;
use App\Loan;
use App\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\LoanHelper;
use Tests\TestCase;

use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertNotNull;
use function PHPUnit\Framework\assertTrue;

class LoanTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
    }

    public function test_own_loan_can_be_made()
    {
        $testEquipment  = Equipment::factory()->create();
        $response = $this
            ->actingAs($this->user)
            ->call(
                'POST',
                '/loan',
                [
                    "loaner" => $this->user->name,
                    "items" => [
                        "item1" => [
                            "id" => $testEquipment->id,
                            "quantity" => $testEquipment->quantity,
                            "loanDate" => Carbon::today(),
                            "returnDate" => Carbon::today()->addDay(7),
                        ],
                    ],
                    "description" => "k",
                    "reason" => "Omaan käyttöön"
                ]
            );
        $loan = Loan::where('equipment_id',$testEquipment->id)->first();
        
        assertNotNull($loan);
        assertEquals($loan->state,1);
        $response->assertSessionHasNoErrors();
        $response->assertSessionHas('message','Laina pyyntö lähetetty');
    }
    public function test_scout_event_loan_can_be_made()
    {
        $testEquipment  = Equipment::factory()->create();
        $response = $this
            ->actingAs($this->user)
            ->call(
                'POST',
                '/loan',
                [
                    "loaner" => $this->user->name,
                    "items" => [
                        "item1" => [
                            "id" => $testEquipment->id,
                            "quantity" => $testEquipment->quantity,
                            "loanDate" => Carbon::today(),
                            "returnDate" => Carbon::today()->addDay(7),
                        ],
                    ],
                    "description" => "k",
                    "reason" => "Partiotapahtumaan"
                ]
            );
            
        $loan = Loan::where('equipment_id',$testEquipment->id)->first();
        assertNotNull($loan);
        assertEquals($loan->state,0);
        $response->assertSessionHasNoErrors();
        $response->assertSessionHas('message','Laina lisätty');
    }
    public function test_same_equipment_can_be_loaned_if_quantity_left()
    {
        $testEquipment  = Equipment::factory()->create(['quantity' => 6]);
        $firstLoanResponse = $this
            ->actingAs($this->user)
            ->call(
                'POST',
                '/loan',
                [
                    "loaner" => $this->user->name,
                    "items" => [
                        "item1" => [
                            "id" => $testEquipment->id,
                            "quantity" => $testEquipment->quantity-3,
                            "loanDate" => Carbon::today(),
                            "returnDate" => Carbon::today()->addDay(7),
                        ],
                    ],
                    "description" => "k",
                    "reason" => "Partiotapahtumaan"
                ]
            );
            
        $loan = Loan::where('equipment_id',$testEquipment->id)->first();
        assertNotNull($loan);
        assertTrue($loan->user_id == $this->user->id);
        assertEquals($loan->state,0);
        $firstLoanResponse->assertSessionHasNoErrors();
        $firstLoanResponse->assertSessionHas('message','Laina lisätty');
        
        $response = $this
            ->actingAs($this->user)
            ->call(
                'POST',
                '/loan',
                [
                    "loaner" => $this->user->name,
                    "items" => [
                        "item1" => [
                            "id" => $testEquipment->id,
                            "quantity" => $testEquipment->quantity-3,
                            "loanDate" => Carbon::today(),
                            "returnDate" => Carbon::today()->addDay(7),
                        ],
                    ],
                    "description" => "k",
                    "reason" => "Partiotapahtumaan"
                ]
            );
            
        $loan = Loan::where('equipment_id',$testEquipment->id)->first();
        assertNotNull($loan);
        assertEquals($loan->state,0);
        $response->assertSessionHasNoErrors();
        $response->assertSessionHas('message','Laina lisätty');
    }

    public function test_multiple_equipment_can_be_loaned()
    {
        $testEquipments  = Equipment::factory()->count(3)->create();
        $items = $testEquipments->mapWithKeys(function($testEquipment, $key){
            return [
                "item" . $key =>  [
                    "id" => $testEquipment->id,
                    "quantity" => $testEquipment->quantity,
                    "loanDate" => Carbon::today(),
                    "returnDate" => Carbon::today()->addDay(7),
                ]
            ];
        })->toArray();

        $response = $this
            ->actingAs($this->user)
            ->call(
                'POST',
                '/loan',
                [
                    "loaner" => $this->user->name,
                    "items" => $items,
                    "description" => "k",
                    "reason" => "Partiotapahtumaan"
                ]
            );
            $response->assertSessionHasNoErrors();
            $response->assertSessionHas('message','Laina lisätty');
        foreach ($testEquipments as  $testEquipment) {
            $loan = Loan::where('equipment_id',$testEquipment->id)->first();
            assertNotNull($loan);
        }
    }

    public function test_own_loan_can_be_returned()
    {
        $loan = LoanHelper::createLoan($this->user, true);

        $response = $this
            ->actingAs($this->user)
            ->call(
                'DELETE',
                '/loan/' . $loan->id 
            );
        $response->assertSessionHasNoErrors();
        $response->assertOk();
        $response->assertSeeText('Laina plautettu');
    }

    public function test_others_loan_cannot_be_returned()
    {
        $otherUser = User::factory()->create();
        $loan = LoanHelper::createLoan($this->user, true);

        $response = $this
            ->actingAs($otherUser)
            ->call(
                'DELETE',
                '/loan/' . $loan->id 
            );
        $response->assertUnauthorized();
        $response->assertSeeText('Lainan palauttaminen epäonnistui');
    }
}

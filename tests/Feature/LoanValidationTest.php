<?php

namespace Tests\Feature;

use App\Equipment;
use App\User;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class LoanValidationTest extends TestCase
{
  use RefreshDatabase;

  protected function setUp(): void
  {
    parent::setUp();

    $this->testEquipment  = Equipment::factory()->create();
    $this->user = User::factory()->create();
  }

  public function test_returdate_before_loandate_gives_error()
  {
    $response = $this
      ->actingAs($this->user)
      ->call(
        'POST',
        '/loan',
        [
          "loaner" => "Niilo Kurki",
          "items" => [
            "item1" => [
              "id" => $this->testEquipment->id,
              "quantity" => '1',
              "loanDate" => Carbon::today()->addDays(7),
              "returnDate" => Carbon::today()->addDay(),
            ],
          ],
          "description" => "k",
          "reason" => "Partiotapahtumaan"
        ]
      );

    $response->assertSessionHasErrors(['items.item1.loanDate' => 'Lainapäivän pitää olla ennen palautuspäivää']);
  }

  public function test_loandate_in_past_gives_error()
  {

    $response = $this
      ->actingAs($this->user)
      ->call(
        'POST',
        '/loan',
        [
          "loaner" => "Niilo Kurki",
          "items" => [
            "item1" => [
              "id" => $this->testEquipment->id,
              "quantity" => '1',
              "loanDate" => Carbon::today()->subDays(7),
              "returnDate" => Carbon::today()->addDay(),
            ],
          ],
          "description" => "k",
          "reason" => "Partiotapahtumaan"
        ]
      );
    $response->assertSessionHasErrors(['items.item1.loanDate' => 'Lainapäivä ei saa olla menneisyydessä']);
  }
  public function test_returndate_in_past_gives_error()
  {
    $response = $this
      ->actingAs($this->user)
      ->call(
        'POST',
        '/loan',
        [
          "loaner" => $this->user->name,
          "items" => [
            "item1" => [
              "id" => $this->testEquipment->id,
              "quantity" => '1',
              "loanDate" => Carbon::today(),
              "returnDate" => Carbon::today()->subDays(7),
            ],
          ],
          "description" => "k",
          "reason" => "Partiotapahtumaan"
        ]
      );
    $response->assertSessionHasErrors(['items.item1.returnDate' => 'Palautuspäivä ei saa olla menneisyydessä taikka tänään']);
  }
  public function test_loan_item_quantity_more_than_equipment_quantity_left_gives_error()
  {
    $equipment = Equipment::factory()->create([
      'quantity' => 1
    ]);
    $response = $this
      ->actingAs($this->user)
      ->call(
        'POST',
        '/loan',
        [
          "loaner" => $this->user->name,
          "items" => [
            "item1" => [
              "id" => $equipment->id,
              "quantity" => 2,
              "loanDate" => Carbon::today(),
              "returnDate" => Carbon::today()->addDays(7),
            ],
          ],
          "description" => "test",
          "reason" => "Partiotapahtumaan"
        ]
      );
    $response->assertSessionHasErrors(['items.item1.id' => "Varustetta {$equipment->name} ei ole enää jäljellä"]);
  }
  public function test_loan_item_does_not_exist_gives_error()
  {
    $equipment = Equipment::factory()->create();
    $equipment->delete();
    $response = $this
      ->actingAs($this->user)
      ->call(
        'POST',
        '/loan',
        [
          "loaner" => $this->user->name,
          "items" => [
            "item1" => [
              "id" => $equipment->id,
              "quantity" => 2,
              "loanDate" => Carbon::today(),
              "returnDate" => Carbon::today()->addDays(7),
            ],
          ],
          "description" => "test",
          "reason" => "Partiotapahtumaan"
        ]
      );
    $response->assertSessionHasErrors(['items.item1.id' => "Varustetta ei ole"]);
  }
  public function test_no_loan_items_gives_error()
  {
    $response = $this
      ->actingAs($this->user)
      ->call(
        'POST',
        '/loan',
        [
          "loaner" => $this->user->name,
          "items" => [],
          "description" => "test",
          "reason" => "Partiotapahtumaan"
        ]
      );
    $response->assertSessionHasErrors(['items' => "Ainakin yksi laina vaaditaan"]);
  }
}

<?php

namespace Tests\Feature;

use App\User;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class LoanValidationTest extends TestCase
{
  use DatabaseTransactions;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_if_returdate_before_loandate_gives_error()
    {
        $user = User::find(1);

        $response = $this
                    ->actingAs($user)
                    ->call('POST', 
        '/loan', 
        [
      "loaner" => "Niilo Kurki",
      "items" => [
        "item1" =>[
          "id" => '55',
          "quantity" => '1',
          "loanDate" => Carbon::today(),
          "returnDate" => Carbon::today()->subDays(7),
        ],
        ],
      "description" => "k",
      "reason" => "Partiotapahtumaan"
    ]);
    $response->assertSessionHasErrors(['items.item1.loanDate'=> 'Lainapäivän pitää olla ennen palautuspäivää']);
    }

    public function test_if_loandate_in_past_gives_error()
    {
        $user = User::find(1);

        $response = $this
                    ->actingAs($user)
                    ->call('POST', 
        '/loan', 
        [
      "loaner" => "Niilo Kurki",
      "items" => [
        "item1" =>[
          "id" => '55',
          "quantity" => '1',
          "loanDate" => Carbon::today()->subDays(7),
          "returnDate" => Carbon::today()->addDay(),
        ],
        ],
      "description" => "k",
      "reason" => "Partiotapahtumaan"
    ]);
    $response->assertSessionHasErrors(['items.item1.loanDate'=> 'Lainapäivä ei saa olla menneisyydessä']);
    }
    public function test_if_returndate_in_past_gives_error()
    {
        $user = User::find(1);

        $response = $this
                    ->actingAs($user)
                    ->call('POST', 
        '/loan', 
        [
      "loaner" => "Niilo Kurki",
      "items" => [
        "item1" =>[
          "id" => '55',
          "quantity" => '1',
          "loanDate" => Carbon::today(),
          "returnDate" => Carbon::today()->subDays(7),
        ],
        ],
      "description" => "k",
      "reason" => "Partiotapahtumaan"
    ]);
    $response->assertSessionHasErrors(['items.item1.returnDate'=> 'Palautuspäivä ei saa olla menneisyydessä taikka tänään']);
    }
}

<?php

namespace Tests\Feature;

use App\User;
use Carbon\Carbon;
use Tests\TestCase;
use App\KitchenBooking;
use Tests\RefreshTable;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class KitchenBookingTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_new_booking_returns_success()
    {
        $user = User::factory()->create();

        $response = $this
                    ->actingAs($user)
                    ->call('POST', 
                    route('kitchenBooking.store'), 
                    [
                    "group-name" => "Tikkugang",
                    "start-time" => now()->format('Y-m-d\TH:i'),
                    "end-time" => now()->addHour()->format('Y-m-d\TH:i')
                  
                ]);
        $response->assertSessionHasNoErrors();
        $response->assertSessionHas('message','Varaus lisätty');
        
    }
    public function test_error_when_end_time_is_before_start_time()
    {
        $user = User::factory()->create();

        $response = $this
                    ->actingAs($user)
                    ->call('POST', 
                    route('kitchenBooking.store'), 
                    [
                    "group-name" => "Tikkugang",
                    "start-time" => now()->format('Y-m-d\TH:i'),
                    "end-time" => now()->subHour()->format('Y-m-d\TH:i')
                    ]);
        $response->assertSessionHasErrors(['end-time']);
        
    }
    public function test_error_when_group_name_is_empty()
    {
        $user = User::factory()->create();

        $response = $this
                    ->actingAs($user)
                    ->call('POST', 
                    route('kitchenBooking.store'), 
                    [
                    "group-name" => "",
                    "start-time" => now()->format('Y-m-d\TH:i'),
                    "end-time" => now()->addHour()->format('Y-m-d\TH:i')
                    ]);
        $response->assertSessionHasErrors(['group-name']);
        
    }
    public function test_error_when_time_is_not_free()
    {
        $user = User::factory()->create();

        //Create mock data
        $startTime = Carbon::now();
        $endTime = now()->addHour();
        KitchenBooking::factory()->create([
            'start_time' => $startTime->format('Y-m-d\TH:i'),
            'end_time' => $endTime->format('Y-m-d\TH:i'),
        ]);

        $response = $this
                    ->actingAs($user)
                    ->call('POST', 
                    route('kitchenBooking.store'), 
                    [
                    "group-name" => "Tikkugang",
                    "start-time" => $endTime->subMinutes(30)->format('Y-m-d\TH:i') ,
                    "end-time" => $endTime->addMinutes(30)->format('Y-m-d\TH:i')
                    ]);
        $response->assertSessionHasErrors(['time']);
        
    }
}

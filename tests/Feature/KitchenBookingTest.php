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
    use RefreshTable;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_new_booking_returns_success()
    {
        $this->RefreshTable('kitchen_bookings');
        $user = User::find(1);

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
        $this->RefreshTable('kitchen_bookings');
        $user = User::find(1);

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
        $this->RefreshTable('kitchen_bookings');
        $user = User::find(1);

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
        $this->RefreshTable('kitchen_bookings');
        $user = User::find(1);

        //Create mock data
        $startTime = Carbon::now();
        $endTime = now()->addHour();
        $bookings = KitchenBooking::factory()->create([
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

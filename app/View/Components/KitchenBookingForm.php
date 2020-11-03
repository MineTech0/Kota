<?php

namespace App\View\Components;

use Carbon\Carbon;
use App\KitchenBooking;
use Illuminate\View\Component;

class KitchenBookingForm extends Component
{
    public $bookings;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->bookings = KitchenBooking::whereDate('start_time', '>=', Carbon::today()->toDateString())->get();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.kitchen-booking-form');
    }
}

<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\KitchenBooking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KitchenBookingController extends Controller
{
    public function store(Request $request)
    {
        $request = $request->validate([
            'group-name' => 'required|max:255|string',
            'start-time' => 'required|date_format:Y-m-d\TH:i',
            'end-time' => 'required|date_format:Y-m-d\TH:i|after_or_equal:start-time',
        ]);
        $bookings = KitchenBooking::all();
        $start = Carbon::parse($request['start-time']);
        $end = Carbon::parse($request['end-time']);

        foreach($bookings as $i => $item){
            if(Carbon::parse($item->start_time) <= $start and $start <= Carbon::parse($item->end_time)){
                return redirect()->back()->withErrors(['time' =>"Kyseinen aika ei ole vapaa, tähän aikaan keittiössä on: ".$item->group_name]);
            }
            
            if(Carbon::parse($item->start_time) <= $end and $end <= Carbon::parse($item->end_time)){
                return redirect()->back()->withErrors(['time'=>"Kyseinen aika ei ole vapaa, tähän aikaan keittiössä on: ".$item->group_name]);
            }
        }

        KitchenBooking::create([
            'user_id' => Auth::id(),
            'group_name' => $request['group-name'],
            'start_time' => Carbon::parse($request['start-time']),
            'end_time' => Carbon::parse($request['end-time'])
        ]);
        return redirect()->back()->with('message', 'Varaus lisätty');
    }
}

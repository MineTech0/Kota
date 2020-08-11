<?php
namespace App\Queries;
use App\Equipment;
use App\Loan;

class AvailableLoans 
{
    public static function get()
    {
        $equipment = Equipment::with('loan')->get();
        $loans = Loan::all();
        $available = $equipment->map(function ($item) use ($loans)
        {
            if($loans->contains('equipment_id',$item->id))
            {
                $loans->each(function($loan) use ($item){
                    if($loan->equipment_id == $item->id )
                    {
                        $item->quantity -= $loan->state == 3 ? 0 : $loan->quantity;//Hylättyä hakemusta ei lasketa mukaan vaan se on mukana lainattavissa 
                    }
                });
                return $item;
            }
            else
            {
                return $item;
            }
        });

        return $available;
    }
    public static function getOne($id)
    {
        $item = Equipment::with('loan')->find($id);
        $loan = Loan::where('equipment_id',$id)->first();
        if($loan != null)
        {
            $item->quantity -= $loan->state == 3 ? 0 : $loan->quantity;
            return $item;
        }
        else
        {
            return $item;
        }
        
    }
    
}
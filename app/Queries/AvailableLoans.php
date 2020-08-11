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
                $loan = $loans->firstWhere('equipment_id',$item->id);
                $item->quantity -= $loan->quantity;
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
            $item->quantity -= $loan->quantity;
            return $item;
        }
        else
        {
            return $item;
        }
        
    }
    
}
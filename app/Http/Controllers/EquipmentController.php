<?php

namespace App\Http\Controllers;

use App\Equipment;
use Illuminate\Http\Request;
use App\Queries\AvailableLoans;

class EquipmentController extends Controller
{

    public function show($id)
    {
        $equipment = AvailableLoans::getOne($id);

        return response()->json([
            'name' => $equipment->name,
            'id' => $equipment->id,
            'loan_time' => $equipment->loan_time,
            'quantity' => $equipment->quantity
        ]); 
    }
}

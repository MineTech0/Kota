<?php

namespace App\Http\Controllers;

use App\Equipment;
use Illuminate\Http\Request;

class EquipmentController extends Controller
{

    public function show(Equipment $equipment)
    {
        return response()->json([
            'name' => $equipment->name,
            'id' => $equipment->id,
            'loan_time' => $equipment->loan_time,
            'quantity' => $equipment->quantity
        ]); 
    }
}

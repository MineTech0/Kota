<?php

namespace App\Http\Controllers;

use App\Equipment;
use App\Loan;
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
    public function index()
    {
        return view('equipment.index',[
            'equipment'=> Equipment::all(),
            'loans'=>Loan::with('equipment')->where('state','=',0)->orWhere('state','=',2)->get()
        ]);
    }
}

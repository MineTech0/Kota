<?php

namespace App\Http\Controllers;

use App\Equipment;
use App\Http\Requests\LoanStoreRequest;
use App\Loan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoanController extends Controller
{
    public function create()
    {
        
        return view('loan.create',[
            'equipment'=> Equipment::all(),
            'own_loans' => Loan::where('user_id',Auth::id())->with('equipment')->get()
         ]);
    }

    public function store(LoanStoreRequest $request)
    {
        $data = $request->validated();

        foreach ($data['items'] as $item) {
            Loan::create([
                'user_id'=> Auth::id(),
                'desc'=> $data['description'],
                'reason'=>$data['reason'],
                'loan_date'=> $item['loanDate'] ,
                'return_date'=>$item['returnDate'] ,
                'quantity'=>$item['quantity'] ,
                'equipment_id'=> $item['id']
                ]);
            }
        return redirect()->back()->with('message', 'Laina lisätty');
    }
    public function show(Loan $loan)
    {
        return view('components.modal_info',['loan'=> $loan]);
    }
}

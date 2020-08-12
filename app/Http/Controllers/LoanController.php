<?php

namespace App\Http\Controllers;

use App\Loan;
use App\Equipment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\LoanStoreRequest;
use App\Queries\AvailableLoans;

class LoanController extends Controller
{
    public function create()
    {
        
        return view('loan.create',[
            'equipment'=> AvailableLoans::get(),
            'own_loans' => Loan::where('user_id',Auth::id())->with('equipment')->get()
         ]);
    }

    public function store(LoanStoreRequest $request)
    {
        $data = $request->validated();

        if($data['reason']=='Partio tapahtumaan'){
            $state = 0;
            $message = 'Laina lisätty';
        }
        else{
            $state = 1;
            $message = 'Laina pyyntö lähetetty';
        }
        foreach ($data['items'] as $item) {
            Loan::create([
                'user_id'=> Auth::id(),
                'desc'=> $data['description'],
                'reason'=>$data['reason'],
                'loan_date'=> $item['loanDate'] ,
                'return_date'=>$item['returnDate'] ,
                'quantity'=>$item['quantity'] ,
                'equipment_id'=> $item['id'],
                'state'=> $state,
                ]);
            }
        return redirect()->back()->with('message', $message);
    }
    public function show(Loan $loan)
    {
        return view('components.modal_info',['loan'=> $loan]);
        
    }
    public function destroy(Loan $loan)
    {
        if($loan->user_id == Auth::id())
        {
            $loan->delete();
        }
    }
    public function update(Loan $loan, Request $request)
    {
        $loan->state = $request['state'];
        $loan->save();
        return response(200);
    }
    public function accept(Loan $loan)  
    {
        if($loan->state == 1)
        {
            return view('components.modal_loan',['loan'=> $loan]);
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Loan;
use Illuminate\Http\Request;
use App\Queries\AvailableLoans;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\LoanStoreRequest;
use App\Mail\LoanAccepted;
use Illuminate\Support\Facades\Storage;

class LoanController extends Controller
{
    public function create()
    {
        
        return view('loan.create',[
            'equipment'=> AvailableLoans::get(),
            'own_loans' => Loan::where('user_id',Auth::id())->with('equipment')->get(),
            'guide_url'=> Storage::url('pappilaOhje.pdf')
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
        $loan->state = $request['state']; // 0: partio tapahtumaan, 1: odottaa, 2: hyväksytty, 3: ei hyväksytty
        Mail::to($loan->user->email)->send(new LoanAccepted($loan));
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

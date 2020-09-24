<?php

namespace App\Http\Controllers;

use App\Feedback;
use App\Loan;
use App\User;
use Illuminate\Http\Request;

class ManagementController extends Controller
{
    

    public function __construct()
    {
       // $this->middleware('can:access_management');
    }

    public function index()
    {
        return view('management',[
            'feedback'=>Feedback::with('user')->get(),
            'users'=> User::with('roles')->get(),
            'loans'=> Loan::where('state',1)->get()
            ]);
    }

    //
}

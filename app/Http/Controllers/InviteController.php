<?php

namespace App\Http\Controllers;

use App\Invite;
use App\Mail\InviteCreated;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Mail;

class InviteController extends Controller
{

    public function index()
    {
        //
    }


    public function create()
    {
        return view('invite.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'emails' => 'required|array|min:1',
            'emails.*' => 'required|email|unique:users,email|unique:invites,email'
        ]);

    foreach ($request['emails'] as $key => $email) {

        do {   
            $token = Str::random(32);
        } 
        while (Invite::where('token', $token)->first());

        $url = URL::temporarySignedRoute('create.user', now()->addDay(), [
            'token' => $token
        ]);
        $invite = Invite::create([
            'email' => $email,
            'token' => $token,
            'url'=> $url
        ]);
        
        Mail::to($email)->send(new InviteCreated($invite));
            
        }
    return redirect()
        ->back()->with('message','Kutsut lähetetty');
    }

}

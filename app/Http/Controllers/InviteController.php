<?php

namespace App\Http\Controllers;

use Exception;
use App\Invite;
use App\Mail\InviteCreated;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class InviteController extends Controller
{

    public function index()
    {
        //
    }


    public function create()
    {
        
        return view('invite.create',[
            'invites' => Invite::whereNotIn('email', DB::table('users')->pluck('email'))->get()
        ]);
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

        $url = URL::temporarySignedRoute('create.user', now()->addWeek(), [
            'token' => $token
        ]);
        $invite = Invite::create([
            'email' => $email,
            'token' => $token,
            'url'=> $url
        ]);
            try {
                Mail::to($email)->send(new InviteCreated($invite));
            } catch (Exception $e) {
                $invite->delete();
                $message = $e->getMessage();
                return redirect()->back()->withErrors(["Sending failed"=>$message]);
            }
        
            
        }
    return redirect()
        ->back()->with('message','Kutsut lähetetty');
    }


    //resend the invitation
    public function reSend(Invite $invite)
    {

        $url = URL::temporarySignedRoute('create.user', now()->addWeek(), [
            'token' => $invite->token
        ]);
        $invite->url = $url;
        $invite->save();
        try {
            Mail::to($invite->email)->send(new InviteCreated($invite));
        } catch (Exception $e) {
            $invite->delete();
            $message = $e->getMessage();
            return redirect()->back()->withErrors(["Sending failed"=>$message]);
        }
        return redirect()
        ->back()->with('message','Kutsu uudelleen lähetetty');
    }

}

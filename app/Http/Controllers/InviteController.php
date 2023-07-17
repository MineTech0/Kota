<?php

namespace App\Http\Controllers;

use Exception;
use App\Invite;
use App\Mail\Invite as MailInvite;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class InviteController extends Controller
{
    public function create()
    {

        return view('invite.create', [
            'invites' => Invite::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users,email|unique:invites,email'
        ]);

        $token = Str::random(32);

        $url = URL::temporarySignedRoute('create.user', now()->addWeeks(2), [
            'token' => $token
        ]);

        $email = $request['email'];

        $invite = Invite::create([
            'email' => $email,
            'token' => $token,
            'url' => $url
        ]);

        try {
            Mail::to($email)->send(new MailInvite($invite));
        } catch (Exception $e) {
            $invite->delete();
            $message = $e->getMessage();
            return response()->json(['message' => $message], 500);
        }

        return response()->json(['message' => 'Kutsu lähetetty'], 201);
    }


    /**
     * Resend the invite
     */
    public function reSend(Request $request)
    {
        $invite = Invite::findOrFail($request->id);

        $url = URL::temporarySignedRoute('create.user', now()->addWeeks(2), [
            'token' => $invite->token
        ]);

        $invite->url = $url;
        $invite->save();

        try {
            Mail::to($invite->email)->send(new MailInvite($invite));
        } catch (Exception $e) {
            $message = $e->getMessage();
            return response()->json(['message' => $message], 500);
        }
        return response()->json(['message' => 'Kutsu lähetetty'], 200);
    }

    /** 
     * Delete the invite
     */
    function destroy(Invite $invite) 
    {
        $invite->delete();
        return response()->json(['message' => 'Kutsu poistettu'], 200);
    }
}

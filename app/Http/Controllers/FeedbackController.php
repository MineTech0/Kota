<?php

namespace App\Http\Controllers;

use App\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class FeedbackController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('feedback');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'heading' => 'required|max:255',
            'description' => 'required|max:500',
            'attachment' => 'nullable',
        ]);

        Feedback::create([
            'heading' => $request['heading'],
            'description' => $request['description'],
            'attachment' => $request['attachment'],
            'user_id' => $request->has('anonym') ? null : Auth::id(),
            'attachment' => $request->hasFile('attachment') ? $request->file('attachment')->store('attachments') : null,
        ]);
        return redirect()->back()->with('message', 'Palaute lähetetty');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Feedback  $feedback
     * @return \Illuminate\Http\Response
     */
    public function show(Feedback $feedback)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Feedback  $feedback
     * @return \Illuminate\Http\Response
     */
    public function edit(Feedback $feedback)
    {
        //
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Feedback  $feedback
     * @return \Illuminate\Http\Response
     */
    public function destroy(Feedback $feedback)
    {
        //
    }
    public function attachment(Feedback $feedback)
    {
        return Storage::download($feedback->attachment, 'Liite_'.$feedback->id.'.'.substr(strrchr($feedback->attachment,'.'),1));
    }
}

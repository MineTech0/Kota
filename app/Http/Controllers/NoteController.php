<?php

namespace App\Http\Controllers;

use App\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NoteController extends Controller
{
   public function show(Note $note)
   {
       return view('components.modal',[
        'heading'=> $note->heading,
        'name'=> $note->user->name,
        'text'=> $note->text
       ]);

   }
   public function create()
   {
       return view('note-create');
   }
   public function store(Request $request)
   {
    $request->validate([
        'title' => 'required|max:255',
        'description' => 'required|max:500'
    ]);

    Note::create([
        'heading' => $request['title'],
        'text' => $request['description'],
        'user_id' => Auth::id()
    ]);
    return redirect()->back()->with('message', 'Ilmoitus julkaistu');
   }
}

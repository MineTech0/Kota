<?php

namespace App\Http\Controllers;

use App\Note;
use Illuminate\Http\Request;

class NoteController extends Controller
{
   public function getNote(Request $request)
   {
       $note = Note::find($request->id);
       //dd($note);
       return view('components.modal',[
        'note'=> $note
       ]);

   }
   
}

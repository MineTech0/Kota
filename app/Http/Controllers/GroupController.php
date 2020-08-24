<?php

namespace App\Http\Controllers;

use App\Contact;
use App\Group;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('groups',['groups'=> Group::all()]);
    }

    public function contact($id)
    {
        return view('components.modal_contact',[
            'contact'=>Contact::where('group_id',$id)->firstOrFail()
        ]);
    }
}

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
        return view('group.index',['groups'=> Group::all()]);
    }

    public function contact($id)
    {
        
        return view('components.modal_contact',[
            'contact'=>Contact::where('group_id',$id)->firstOrFail()
        ]);
    }
    public function edit(Group $group)
    {
        return view('group.edit',['group'=> $group,'weekDays'=>['Ma','Ti','Ke','To','Pe','La','Su']]);
    }
}

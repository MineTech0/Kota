<?php

namespace App\Http\Controllers;

use App\User;
use App\Invite;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Spatie\Permission\Models\Role;

class UserController extends Controller
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
    public function create($token)
    {
        $invite = Invite::where('token', $token)->first();
        
        if (!$invite) {
            abort(Response::HTTP_NOT_FOUND);
        }

        return view('auth.register', ['invite'=> $invite]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($user)
    {
        $user = User::findOrFail($user);   
        $roles = Role::all();   

        return view('components.modal_user', ['user'=> $user, 'roles'=>$roles ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);
        $role = Role::find($request['roleSelect']);
        
        if($user->hasRole($role->name))
        {
            return redirect()->back()->withErrors('Käyttäjällä on jo tämä rooli');
        }
        elseif($user->hasRole('super-admin'))
        {
            return redirect()->back()->withErrors('Super-adminia ei voi muokata');
        }
        elseif($role->name == 'super-admin')
        {
            return redirect()->back()->withErrors('Super-admin roolia ei voi lisätä');
        }
        else
        {
            $user->assignRole($role->name);
            return redirect()->back()->with('message', 'Rooli lisätty');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyRole(User $user, Role $role)
    {
        if($role->name == 'super-admin')
        {
            return response()->json(['success' => false, 'error' => 'Super-admin roolia ei voi poistaa'], 400);
            
        }
        elseif($user->hasRole($role->name))
        {
            $user->removeRole($role->name);
        }
        else
        {
            return response()->json(['error' => 'Käyttäjällä ei ole tätä roolia'], 400);
        }
    }
}

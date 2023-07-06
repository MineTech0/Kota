<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
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
        return view('management.index-users', ['users' => User::all()->load('roles'), 'roles' => Role::all()]);
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
        //
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
     * @return \Illuminate\Http\Response
     */
    public function update(User $user, UserRequest $request)
    {
        $validated = $request->validated();
        //TODO
    }

    /**
     * Update user roles
     *
     * @return \Illuminate\Http\Response
     */
    public function updateRoles(User $user, Request $request)
    {
        
        if($user->hasRole('super-admin'))
        {
            return response()->json(['message' => 'Super-adminia ei voi muokata'], 403);
        }

        $roles = $request->roles;

        //remove super-admin
        $superAdmin = Role::where('name', 'super-admin')->first();
        $roles = array_diff($roles, [$superAdmin->id]);

        //sync roles
        $user->syncRoles($roles);

        return response()->json(['message' => 'Roolit päivitetty']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        if($user->hasRole('super-admin'))
        {
            return response()->json(['message' => 'Super-adminia ei voi poistaa'], 403);
        }
        $user->groups()->detach();
        $user->delete();

        return response()->json(['message' => 'Käyttäjä poistettu']);
    }
}

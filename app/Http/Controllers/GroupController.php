<?php

namespace App\Http\Controllers;

use App\Contact;
use App\Group;
use App\Http\Requests\GroupRequest;
use App\User;
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
        $groups = Group::all();
        return view('group.index', ['groups' => $groups]);
    }

    public function userGroups() {
        $groups = auth()->user()->groups;
        $groups->load('expenses');
        return view('group.user-groups', ['groups' => $groups]);
        
    }

    public function contact($id)
    {

        return view('components.modal_contact', [
            'contact' => Contact::where('group_id', $id)->firstOrFail()
        ]);
    }
    public function edit(Group $group)
    {
        $group->load('leaders');

        return view('group.edit', [
            'group' => $group,
            'weekDays' => collect(config('kota.weekDays')),
            'ageGroups' => collect(config('kota.groups.ageGroups')),
            'users' => User::all()
        ]);
    }

    public function update(Group $group, GroupRequest $request)
    {
        $validated = $request->validated();

        $group->update($validated);

        $group->leaders()->sync(collect($validated['leaders'])->map(function ($leader) {
            return $leader['id'];
        })->toArray());

        return response()->json([
            'message' => 'Ryhmä tallennettu'
        ]);
    }
    public function destroy(Group $group)
    {
        $group->contact()->delete();
        $group->leaders()->detach();
        $group->delete();

        return response()->json([
            'message' => 'Ryhmä poistettu'
        ]);
    }
    public function create()
    {
        return view('group.create', ['weekDays' => collect(config('kota.weekDays')), 'ageGroups' => collect(config('kota.groups.ageGroups')), 'users' => User::all()]);
    }
    public function store(GroupRequest $request)
    {
        $validated = $request->validated();

        $group = Group::create($validated);

        $group->leaders()->attach(collect($validated['leaders'])->map(function ($leader) {
            return $leader['id'];
        })->toArray());

        return response()->json([
            'message' => 'Uusi ryhmä luotu'
        ], 201);
    }
}

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

    public function contact($id)
    {

        return view('components.modal_contact', [
            'contact' => Contact::where('group_id', $id)->firstOrFail()
        ]);
    }
    public function edit(Group $group)
    {
        return view('group.edit', [
            'group' => $group,
            'weekDays' => collect(config('kota.weekDays')),
            'ageGroups' => collect(config('kota.groups.ageGroups'))
        ]);
    }

    public function update(Group $group, GroupRequest $request)
    {
        $validated = $request->validated();

        $group->name = $validated['group_name'];
        $group->day = $validated['meeting_day'];
        $group->time = $validated['meeting_start'] . '-' . $validated['meeting_end'];
        $group->repeat = $validated['repeat'];
        $group->age = $validated['age'];
        $group->leaders = implode(',', $validated['leader_list']);
        $group->save();

        return redirect()->route('groups')->with('message', 'Ryhmä tallennettu');
    }
    public function destroy(Group $group)
    {
        $group->contact()->delete();
        $group->delete();
        return redirect()->route('groups')->with('message', 'Ryhmä poistettu');
    }
    public function create()
    {
        return view('group.create', ['weekDays' => collect(config('kota.weekDays')), 'ageGroups' => collect(config('kota.groups.ageGroups')), 'users' => User::all()]);
    }
    public function store(GroupRequest $request)
    {
        $validated = $request->validated();

        Group::create([
            'name' => $validated['group_name'],
            'day' => $validated['meeting_day'],
            'time' => $validated['meeting_start'] . '-' . $validated['meeting_end'],
            'repeat' => $validated['repeat'],
            'age' => $validated['age'],
            'leaders' => implode(',', $validated['leader_list'])
        ]);
        return redirect()->route('groups')->with('message', 'Uusi ryhmä luotu');
    }
}

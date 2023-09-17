<?php

namespace App\Http\Controllers;

use App\Group;
use App\Http\Requests\GroupRequest;
use App\User;
use App\Utils\SeasonUtil;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $groups = Group::all();
        $groups->load('leaders');

        return view('group.index', ['groups' => $groups, 'canEdit' => $request->user()->hasPermissionTo('access_management'), 'ageGroups' => collect(config('kota.groups.ageGroups'))]);
    }

    public function userGroups()
    {
        $groups = auth()->user()->groups;
        $groups->load('expenses');

        //only show current season expenses
        $currentSeason = SeasonUtil::getCurrentSeasonDates(Carbon::now())['currentSeasonDates'];

        $groups->each(function ($group) use ($currentSeason) {
            $group->expenses = $group->expenses->filter(function ($expense) use ($currentSeason) {
                return $expense->expense_date->between($currentSeason['start'], $currentSeason['end']);
            });
        });


        return view('group.user-groups', ['groups' => $groups, 'season' => $currentSeason['name']]);
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

        //dont update age
        unset($validated['age']);

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

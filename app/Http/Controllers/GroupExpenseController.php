<?php

namespace App\Http\Controllers;

use App\ClubMoney;
use App\Expense;
use App\Group;
use App\Http\Requests\StoreGroupExpenseRequest;
use App\Queries\GroupExpenses;
use App\Utils\SeasonUtil;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpClient\HttpClient;

class GroupExpenseController extends Controller
{
    /**
     * All users groups and their expenses
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $groups = auth()->user()->groups;
        $groups->load('expenses');

        //only show current season expenses
        $currentSeason = SeasonUtil::getCurrentSeasonDates(Carbon::now())['currentSeasonDates'];

        $groups = GroupExpenses::getUserGroupsAndExpensesBetweenDates(auth()->user()['id'], $currentSeason['start'], $currentSeason['end']);

        //add parent age group to group properties
        $parentAgeGroups = collect(config('kota.groups.parentAgeGroups'));
        $groups->each(function ($group) use ($parentAgeGroups) {
            $parentAgeGroups->each(function ($parentAgeGroup, $key) use ($group) {
                if (in_array($group->age, $parentAgeGroup)) {
                    $group->parentAgeGroup = $key;
                }
            });
        });


        return view('group.user-groups', ['groups' => $groups, 'season' => $currentSeason['name'], 'clubMoney' => ClubMoney::all()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //if user can only edit own groups expenses, find only user groups
        $groups = $request->user()->hasPermissionTo('add_group_expense') ? Group::all() : auth()->user()->groups;

        return view('expenses.create-expenses', [
            'groups' => $groups,
            'expenseInfos' => collect(config('kota.expenses.infos'))
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreGroupExpenseRequest $request)
    {
        $validated = $request->validated();

        // Save original age group and group name
        $group = Group::find($validated['group_id']);
        $validated['original_age_group'] = $group->age;
        $validated['original_group_name'] = $group->name;

        Expense::create($validated);

        return response()->json([
            'message' => 'Kulujen lisääminen onnitui', 201
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
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
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

<?php

namespace App\Http\Controllers;

use App\Expense;
use App\Group;
use App\Http\Requests\StoreGroupExpenseRequest;
use App\Queries\GroupExpenses;
use App\Utils\SeasonUtil;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request  $request)
    {
        $seasonDates = SeasonUtil::getCurrentSeasonDates(Carbon::now());

        return view('expenses.index-expenses', [
            'currentSeasonExpenses' => GroupExpenses::getExpensesBetweenDates($seasonDates['currentSeasonDates']['start'], $seasonDates['currentSeasonDates']['end']),
            'previousSeasonExpenses' => GroupExpenses::getExpensesBetweenDates($seasonDates['previousSeasonDates']['start'], $seasonDates['previousSeasonDates']['end']),
            'seasons' => collect([ $seasonDates['previousSeasonDates']['name'], $seasonDates['currentSeasonDates']['name']]),
            'canDelete' => $request->user()->hasPermissionTo('delete_edit_group_expense')
        ]);
    }

    /**
     * Show form for creating new expenses
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('expenses.create-expenses', [
            'groups' => Group::all(),
            'expenseInfos' => collect(config('kota.expenses.infos'))
        ]);
    }

    /**
     * Stores new group expense
     *
     * @param  \Illuminate\Http\StoreGroupExpenseRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function storeGroup(StoreGroupExpenseRequest $request)
    {
        $validated = $request->validated();
        $validated['acceptor_id'] = Auth::id();

        // Save original age group and group name
        $group = Group::find($validated['group_id']);
        $validated['original_age_group'] = $group->age;
        $validated['original_group_name'] = $group->name;

        Expense::create($validated);

        return response()->json([
            'message' => 'Kulujen lisääminen onnitui'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function show(Expense $expense)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function edit(Expense $expense)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Expense $expense)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function destroy(Expense $expense)
    {
        $expense->delete();
        
        return response()->json([
            'message' => 'Kulun poistaminen onnistui'
        ]);
    }
}

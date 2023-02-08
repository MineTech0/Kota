<?php

namespace App\Http\Controllers;

use App\Expense;
use App\Group;
use App\Http\Requests\StoreGroupExpenseRequest;
use Illuminate\Http\Request;

class ExpenseController extends Controller
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
     * Storese new group expense
     *
     * @param  \Illuminate\Http\StoreGroupExpenseRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function storeGroup(StoreGroupExpenseRequest $request)
    {
        Expense::create($request->validated()->safe());

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
        //
    }
}

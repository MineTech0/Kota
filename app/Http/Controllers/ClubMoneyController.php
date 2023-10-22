<?php

namespace App\Http\Controllers;

use App\ClubMoney;
use App\Http\Requests\StoreClubMoneyRequest;
use Illuminate\Http\Request;

class ClubMoneyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clubMoneyCategories = collect(config('kota.budget.clubMoney.categories'));

        // Get all club money values from database with name on category
        $clubMoneyValues  = ClubMoney::all();

        $clubMoneys = $clubMoneyCategories->map(function ($category, $id) use ($clubMoneyValues) {
            return [
                'id' => $id,
                'age_group' => $category,
                'amount' => $clubMoneyValues->where('age_group', $category)->first()->amount ?? 0
            ];
        });
        
        return view('budget.index', [
            'clubMoneys' => $clubMoneys,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreClubMoneyRequest $request)
    {
        $validated = $request->validated();

        ClubMoney::updateOrCreate(
            ['age_group' => $validated['age_group']],
            ['amount' => $validated['amount']]
        );

        return response()->json([
            'message' => $validated['age_group'] . ' budjetin päivittäminen onnistui', 201
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ClubMoney  $clubMoney
     * @return \Illuminate\Http\Response
     */
    public function show(ClubMoney $clubMoney)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ClubMoney  $clubMoney
     * @return \Illuminate\Http\Response
     */
    public function edit(ClubMoney $clubMoney)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ClubMoney  $clubMoney
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ClubMoney $clubMoney)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ClubMoney  $clubMoney
     * @return \Illuminate\Http\Response
     */
    public function destroy(ClubMoney $clubMoney)
    {
        //
    }
}

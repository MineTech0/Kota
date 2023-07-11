<?php

namespace App\Http\Controllers;

use App\Loan;
use App\Equipment;
use Illuminate\Http\Request;
use App\Queries\AvailableLoans;
use Illuminate\Support\Facades\File;
use App\Http\Requests\StoreEquipment;
use App\Enums\LoanStateEnum;

class EquipmentController extends Controller
{

    public function available($id)
    {
        $equipment = AvailableLoans::getOne($id);

        return response()->json([
            'name' => $equipment->name,
            'id' => $equipment->id,
            'loan_time' => $equipment->loan_time,
            'quantity' => $equipment->quantity
        ]);
    }
    public function index()
    {
        return view('equipment.index', [
            'equipment' => Equipment::all(),
            'loans' => Loan::with('equipment')
                ->where('state', '=', LoanStateEnum::SCOUT_EVENT)
                ->orWhere('state', '=', LoanStateEnum::ACCEPTED)
                ->get(),
            'formOptions' => collect(config('kota.equipment.formOptions'))
        ]);
    }
    public function create()
    {
        return view('equipment.create');
    }
    public function store(StoreEquipment $request)
    {
        $validated = $request->validated();
        $validated['picture'] = $request->hasFile('picture') ? $request->file('picture')->store('equipment', ['disk' => 'public']) : null;
        Equipment::create($validated);

        return redirect()->back()->with('message', 'Varuste lisätty');
    }
    public function edit(Equipment $equipment)
    {
        return view('equipment.edit', ['equipment' => $equipment]);
    }
    public function update(StoreEquipment $request, Equipment $equipment)
    {
        $validated = $request->validated();
        if ($request->hasFile('picture')) {
            $validated['picture'] =  $request->file('picture')->store('equipment', ['disk' => 'public']);
            File::delete($equipment->picture);
        } else {
            $validated['picture'] = null;
        }

        $equipment->update($validated);

        return redirect()->back()->with('message', 'Varuste tallennettu');
    }
}

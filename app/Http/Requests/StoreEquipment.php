<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class StoreEquipment extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|max:255',
            'weight' => 'nullable|max:500',
            'form' => 'in:Hyvä,Huono,Uusi,Rikki,Kulunut|required',
            'location' => 'required',
            'quantity' => 'required|integer|min:1',
            'info' => 'required|max:255',
            'serial' => ['required',Rule::unique('equipment', 'serial')->ignore($this->equipment)],
            'picture' => 'nullable|image',
        ];
    }
}

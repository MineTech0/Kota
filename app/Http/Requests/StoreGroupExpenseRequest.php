<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreGroupExpenseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('access_management');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'groupId' => 'required|exists:groups,id',
            'amount' => 'required|decimal:2|min:0.1',
            'expense_date' => 'required|date|before_or_equal:Today',
            'description' => 'required|string|max:255'
        ];
    }
}

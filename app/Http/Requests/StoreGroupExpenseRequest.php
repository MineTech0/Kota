<?php

namespace App\Http\Requests;

use Carbon\Carbon;
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
 * Prepare the data for validation.
 *
 * @return void
 */
protected function prepareForValidation()
{
    $this->merge([
        'expense_date' => Carbon::createFromTimestampMs($this->expense_date),
        'group_id' => $this->groupId
    ]);
}

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'group_id' => 'required|exists:groups,id',
            'amount' => 'required|numeric|min:0.1',
            'expense_date' => 'required|date|after:Yesterday',
            'description' => 'required|string|max:255'
        ];
    }
}
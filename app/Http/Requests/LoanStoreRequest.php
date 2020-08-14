<?php

namespace App\Http\Requests;

use App\Rules\QuantityLeft;
use Illuminate\Foundation\Http\FormRequest;

class LoanStoreRequest extends FormRequest
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
            'items' => 'required|array|min:1',
            'items.*.id' => ['required','integer', new QuantityLeft($this)],
            'items.*.loanDate' => 'required|date',
            'items.*.returnDate' => 'required|date',
            'description'=> 'required',
            'reason' => 'required'
        ];
    }
    /**
 * Get the error messages for the defined validation rules.
 *
 * @return array
 */
public function messages()
{
    return [
        'items.required' => 'Ainakin yksi laina vaaditaan'
    ];
}
}

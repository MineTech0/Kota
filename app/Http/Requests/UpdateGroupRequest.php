<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateGroupRequest extends FormRequest
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
            'group_name' => 'required|string',
            'meeting_day' => 'in:Ma,Ti,Ke,To,Pe,La,Su|required',
            'meeting_start' => 'required|date_format:H:i',
            'meeting_end' => 'required|date_format:H:i',
            'repeat' => 'string|required',
            'age' => 'string|required',
            'leader_list' => 'required|array|min:1',
            'leader_list.*' => 'string|nullable'

        ];
    }
}

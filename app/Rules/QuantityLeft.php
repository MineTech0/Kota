<?php

namespace App\Rules;

use App\Queries\AvailableLoans;
use Illuminate\Contracts\Validation\Rule;

class QuantityLeft implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return AvailableLoans::getOne($value)->quantity > 0;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return ':attribute ei ole enää jäljellä';
    }
}

<?php

namespace App\Rules;

use App\Queries\AvailableLoans;
use Illuminate\Contracts\Validation\Rule;

class QuantityLeft implements Rule
{
    

    public function __construct($request)
    {
        
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
        $index = explode('.', $attribute)[1];
        $quantity = request()->input("items.{$index}.quantity");
        return AvailableLoans::getOne($value)->quantity - $quantity >= 0;
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

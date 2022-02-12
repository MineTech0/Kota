<?php

namespace App\Rules;

use App\Equipment;
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
        $this->itemId = $value;
        $index = explode('.', $attribute)[1];
        $quantity = request()->input("items.{$index}.quantity");
        $availableItem = AvailableLoans::getOne($value);
        if ($availableItem == null)
        {
            return false;
        }
        return $availableItem->quantity - $quantity >= 0;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        $item = Equipment::find($this->itemId);
        $name = optional($item)->name;
        if($name == null) {
            return "Varustetta ei ole";
        }
        return "Varustetta {$name} ei ole enää jäljellä";
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Equipment extends Model
{
    public function loan()
    {
        return $this->hasOne(Loan::class);
    }
}

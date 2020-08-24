<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    public function contact()
    {
        return $this->hasOne(Contact::class);
    }
}

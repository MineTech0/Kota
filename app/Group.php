<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;
    public function contact()
    {
        return $this->hasOne(Contact::class);
    }
    public function getTimeAttribute($value)
    {
        return str_replace('.',':',$value);
    }
}

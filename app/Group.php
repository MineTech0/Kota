<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $fillable = ['name','meeting_day', 'meeting_start','meeting_end','repeat','age'];
    use HasFactory;

    public function getTimeAttribute($value)
    {
        return str_replace('.',':',$value);
    }

    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }

    public function leaders()
    {
        return $this->belongsToMany(User::class);
    }
}

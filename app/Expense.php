<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = ['group_id','description','amount','expense_date', 'acceptor_id'];

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function acceptor()
    {
        return $this->hasOne(User::class);
    }
}

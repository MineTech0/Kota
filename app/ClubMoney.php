<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClubMoney extends Model
{
    protected $fillable = ['age_group', 'amount'];
    
    use HasFactory;
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    protected $fillable = ['desc','user_id','equipment_id','loan_date','return_date','reason','quantity'];
    protected $casts = [
        'options' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
    public function equipment()
    {
        return $this->belongsTo('App\Equipment');
    }
}

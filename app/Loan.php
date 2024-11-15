<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Enums\LoanStateEnum;

class Loan extends Model
{
    protected $fillable = ['desc','user_id','equipment_id','loan_date','return_date','reason','quantity','state'];
    protected $casts = [
        'options' => 'array',
        'state' => LoanStateEnum::class,
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
    public function equipment()
    {
        return $this->belongsTo('App\Equipment');
    }

    public function getLoanDateAttribute($value)
    {
        return Carbon::parse($value)->format('d/m/Y');
    }
    public function getReturnDateAttribute($value)
    {
        return Carbon::parse($value)->format('d/m/Y');
    }

}

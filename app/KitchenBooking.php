<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KitchenBooking extends Model
{
    use HasFactory;
    protected $fillable = ['user_id','start_time','end_time','group_name'];

    public function getStartTimeAttribute($value)
    {
        return Carbon::parse($value)->format('Y/m/d H:i');
    }
    public function getEndTimeAttribute($value)
    {
        return Carbon::parse($value)->format('Y/m/d H:i');
    }
}

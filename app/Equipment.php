<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['name','weight','form','location','quantity','info','serial','picture'];

    public function loan()
    {
        return $this->hasMany(Loan::class);
    }
    public function setSerialAttribute($value)
    {
        $this->attributes['serial'] = strtoupper($value);
    }
    public function setWeightAttribute($value)
    {
        $this->attributes['weight'] = $value ?? 0;
    }
}

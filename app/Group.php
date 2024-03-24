<?php

namespace App;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $fillable = ['name','meeting_day', 'meeting_start','meeting_end','repeat','age','member_count'];
    use HasFactory;

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['parent_age_group'];

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
    //not working
    private function convertAgeToAgeGroup($age)
    {
        $ageGroups = collect(config('kota.groups.parentAgeGroups'));
        foreach ($ageGroups as $key => $ageGroup) {
            if (in_array($age, $ageGroup)) {
                return $key;
            }
        }

    }

    protected function getParentAgeGroupAttribute()
    {
        return $this->convertAgeToAgeGroup($this->age);
    }
}

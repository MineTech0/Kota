<?php

namespace App;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    protected $fillable = ['heading','description','attachment','user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

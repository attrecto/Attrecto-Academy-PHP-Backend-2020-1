<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BadgeUser extends Model
{
    use HasFactory;

    protected $fillable = [
        'badge_id',
        'user_id'
    ];

    public function user(){
        return $this->hasOne('App\Models\User','id','user_id');
    }

    public function badge(){
        return $this->hasOne('App\Models\Badge','id','badge_id');
    }
}

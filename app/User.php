<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\UserJoin;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'phone',
    ];
    
    public $timestamps= false;

    public function integral(){
        return $this->hasOne('App\Models\UserIntegral', 'user_id', 'id');
    }
}

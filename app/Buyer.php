<?php

namespace App;
// use Illuminate\Database\Eloquent\Model;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class Buyer extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $guard = 'buyer';

    protected $fillable = [
        'first_name', 'last_name', 'email', 'phone', 'image', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];
}

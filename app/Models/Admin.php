<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Relations\HasOne;


class Admin extends Authenticatable
{
    use HasFactory;

    protected $guard = 'admin';

    protected $fillable = [
        'nom', 'email', 'password', 'role',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];
    
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function user()
    {
        return $this->morphOne(User::class, 'roleable');
    }

}

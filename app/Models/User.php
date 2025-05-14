<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    public function roleable()
    {
        return $this->morphTo();
    }
    use HasFactory, Notifiable;

    protected $fillable = [
        'nom',
        'email', 
        'password', 
        'role',
    ];
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function enseignant()
    {
        return $this->hasOne(Enseignant::class);
    }

    public function etudiant()
    {
        return $this->hasOne(Etudiant::class);
    }
    public function role()
    {
        return $this->belongsTo(Role::class);
    }
    public function absences()
    {
        return $this->hasMany(Absence::class, 'etudiant_id');
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'nom',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function hasRole($role)
    {
        return $this->role === $role;
    }

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

    public function admin()
    {
        return $this->hasOne(Admin::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }
    public function absences()
    {
        return $this->hasMany(Absence::class, 'etudiant_id');
    }
    public function modules()
    {
        return $this->belongsToMany(Module::class, 'module_user', 'user_id', 'module_id')
                    ->withTimestamps();
    }

}

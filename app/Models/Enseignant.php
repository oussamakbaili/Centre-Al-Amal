<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Module;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Enseignant extends authenticatable
{
    use HasFactory;

    protected $guard = 'enseignant';

    protected $fillable = ['user_id', 'nom', 'prenom', 'email', 'module_id', 'photo', 'active', 'module', 'role', 'password','module_id'];

    protected $hidden = [
     'remember_token',
    ];

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($enseignant) {
            if ($enseignant->user) {
                $enseignant->user->delete();
            }
        });
    }

    public function modules()
    {
        return $this->belongsToMany(Module::class, 'enseignant_module', 'enseignant_id', 'module_id');
    }

    public function getModulesStringAttribute()
    {
        return $this->modules->pluck('nom')->implode(', ');
    }

    public function absences()
    {
        return $this->hasMany(Absence::class);
    }

    public function emplois()
    {
        return $this->hasMany(Emploidutemps::class);
    }
}

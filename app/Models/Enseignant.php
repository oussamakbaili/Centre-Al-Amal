<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Module;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Enseignant extends Model
{
    use HasFactory;

    protected $guard = 'enseignant';

    protected $fillable = ['user_id', 'nom', 'prenom', 'email', 'module_id', 'photo', 'active', 'module', 'role', 'password'];

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

    public function module()
    {
        return $this->belongsTo(Module::class, 'module_id');
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

    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    public function classes()
    {
        return $this->hasMany(Classe::class);
    }
}

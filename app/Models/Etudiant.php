<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Etudiant extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'nom', 'prenom', 'date_naissance', 'cin', 'adresse', 'image', 'niveau', 'email', 'telephone'
    ];

    protected $casts = [
        'date_naissance' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($etudiant) {
            $user = User::firstOrCreate(
                ['email' => $etudiant->email],
                [
                    'nom' => $etudiant->nom,
                    'password' => Hash::make('password'), // Mot de passe par défaut
                    'role' => 'etudiant',
                ]
            );

            $etudiant->user_id = $user->id;
        });

        static::deleting(function ($etudiant) {
            $etudiant->user()->delete();
        });
    }

    public function absences()
    {
        return $this->hasMany(Absence::class);
    }

    public function notes()
    {
        return $this->hasMany(Note::class);
    }

    public function emploidutemps()
    {
        return $this->hasMany(Emploidutemps::class);
    }

    public function modules()
    {
        return $this->belongsToMany(Module::class, 'etudiant_module', 'etudiant_id', 'module_id');
    }

    public function groupe()
    {
        return $this->belongsTo(Groupe::class);
    }
}

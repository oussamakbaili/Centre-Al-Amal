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

    public function emplois()
    {
        return $this->hasMany(Emploidutemps::class, 'etudiant_id');
    }

    public function modules()
{
    return $this->belongsToMany(Module::class, 'etudiant_module');
}
public function presences() {
    return $this->hasMany(Presence::class);
}



    public function groupe()
    {
        return $this->belongsTo(Groupe::class);
    }
    public function classes()
    {
        return $this->belongsToMany(Classe::class);
    }

    public function documents()
    {
        return $this->hasMany(Document::class);
    }
}

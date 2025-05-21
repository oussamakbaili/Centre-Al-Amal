<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Classe extends Model
{
    protected $fillable = ['nom', 'description', 'enseignant_id'];

    public function enseignant()
    {
        return $this->belongsTo(Enseignant::class);
    }

    public function etudiants()
    {
        return $this->belongsToMany(Etudiant::class);
    }

    public function documents()
    {
        return $this->hasMany(Document::class);
    }
}

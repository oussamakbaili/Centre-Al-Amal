<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Groupe extends Model
{
    // Relations éventuelles
    public function etudiants()
    {
        return $this->hasMany(Etudiant::class);
    }
}

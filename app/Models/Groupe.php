<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Groupe extends Model
{
    public function etudiants()
    {
        return $this->belongsToMany(Etudiant::class, 'etudiant_groupe', 'groupe_id', 'etudiant_id');
    }

public function modules()
{
    return $this->hasMany(Module::class);
}

    public function emplois()
    {
        return $this->hasMany(Emploi::class);
    }


}

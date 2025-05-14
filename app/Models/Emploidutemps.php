<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Emploidutemps extends Model
{
    use HasFactory;

    protected $table = 'emploi_du_temps'; 

    protected $fillable = ['module_id', 'jour', 'heure_debut', 'heure_fin', 'salle', 'enseignant_id'];

    public function module()
    {
        return $this->belongsTo(Module::class);
    }

    public function enseignant()
    {
        return $this->belongsTo(Enseignant::class);
    }

    public function etudiant()
    {
        return $this->belongsTo(Etudiant::class);
    }
}
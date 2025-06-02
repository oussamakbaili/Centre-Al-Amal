<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Etudiant;
use App\Models\Seance;

class Presence extends Model
{
    protected $fillable = ['etudiant_id', 'seance_id', 'etat', 'heure_arrivee'];

    public function etudiant() {
        return $this->belongsTo(Etudiant::class);
    }

    public function seance() {
        return $this->belongsTo(Seance::class);
    }
}


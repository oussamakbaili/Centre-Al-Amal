<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Emploidutemps extends Model
{
    use HasFactory;

    protected $table = 'emploi_du_temps';

    protected $fillable = ['module_id', 'jour', 'heure_debut', 'heure_fin',
    'salle', 'enseignant_id', 'status', 'scanned_by',];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function module()
    {
        return $this->belongsTo(Module::class);
    }

    public function enseignant()
    {
        return $this->belongsTo(User::class, 'enseignant_id');
    }

    public function etudiant()
    {
        return $this->belongsTo(Etudiant::class);
    }
    public function admin()
    {
        return $this->belongsTo(User::class, 'scanned_by');
    }
}

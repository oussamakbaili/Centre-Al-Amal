<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absence extends Model
{
    use HasFactory;

    protected $fillable = ['etudiant_id', 'module_id', 'enseignant_id', 'etat', 'motif'];

    protected $casts = [
        'date_absence' => 'datetime',
        'justifie' => 'boolean',
    ];

    protected $dates = [
        'date_absence',
        'created_at',
        'updated_at'
    ];

    public function etudiant()
    {
        return $this->belongsTo(Etudiant::class, 'etudiant_id');
    }

    public function enseignant()
    {
        return $this->belongsTo(Enseignant::class, 'enseignant_id');
    }

    public function module()
    {
        return $this->belongsTo(Module::class);
    }
}

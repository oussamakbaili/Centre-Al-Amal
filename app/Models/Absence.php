<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Enseignant;
use App\Models\Etudiant;
use App\Models\Module;
use App\Models\Emploi;

class Absence extends Model
{
    use HasFactory;

    protected $fillable = ['etudiant_id', 'module_id', 'enseignant_id', 'admin_id', 'etat', 'motif', 'date_absence',
        'scanned_at', 'heure_cours', 'scanned_by_admin'
];

    protected $casts = [
        'scanned_at' => 'datetime',
        'date_absence' => 'date',
        'heure_cours' => 'datetime'
    ];

    protected $dates = [
        'date_absence',
        'created_at',
        'updated_at'
    ];


    public function admin()
{
    return $this->belongsTo(User::class, 'admin_id');
}

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
        return $this->belongsTo(Module::class, 'module_id');
    }
    public function emploi()
    {
        return $this->belongsTo(Emploi::class);
    }

    /**
     * Scopes pour filtrer les absences
     */

    public function scopePresent($query)
    {
        return $query->where('etat', 'present');
    }

    public function scopeAbsent($query)
    {
        return $query->where('etat', 'absent');
    }

    public function scopeJustifie($query)
    {
        return $query->where('etat', 'justifie');
    }
}

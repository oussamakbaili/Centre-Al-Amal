<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Module extends Model
{
    use HasFactory;

    protected $fillable = ['nom', 'code', 'description', 'enseignant_id'];
    protected $table = 'modules';

   
   // every module has one enseignant
    public function enseignant()
    {
        return $this->belongsTo(Enseignant::class);
    }
    public function etudiants()
    {
        return $this->belongsToMany(Etudiant::class, 'etudiant_module', 'module_id', 'etudiant_id');
    }  

    public function absences()
    {
        return $this->hasMany(Absence::class);
    }

    public function Emploidutemps()
    {
        return $this->hasMany(Emploidutemps::class);
    }

    public function notes()
    {
        return $this->hasMany(Note::class);
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}


<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Document extends Model
{
    protected $fillable = [
        'enseignant_id',
        'etudiant_id',
        'classe_id',
        'titre',
        'contenu',
        'fichier',
        'module_id',
        'type_contenu'
    ];
    protected $dates = [
        'created_at',
        'updated_at'
    ];

    public function enseignant()
    {
        return $this->belongsTo(Enseignant::class, 'enseignant_id');
    }
    public function etudiant()
    {
        return $this->belongsTo(user::class, 'etudiant_id');
    }

    public function module()
    {
        return $this->belongsTo(Module::class, 'module_id');
    }
    public function classe()
    {
        return $this->belongsTo(Classe::class);
    }

    // Nouvelle méthode pour le type de fichier
    public function getFileTypeAttribute()
    {
        if (!$this->fichier) return null;

        $extension = strtolower(pathinfo($this->fichier, PATHINFO_EXTENSION));

        $types = [
            'pdf' => 'PDF',
            'jpg' => 'Image',
            'jpeg' => 'Image',
            'png' => 'Image',
            'doc' => 'Word',
            'docx' => 'Word',
            'txt' => 'Texte'
        ];

        return $types[$extension] ?? 'Fichier';
    }
}


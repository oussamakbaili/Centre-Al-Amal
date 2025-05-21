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
        'type_contenu'
    ];

    public function enseignant()
    {
        return $this->belongsTo(Enseignant::class);
    }
    public function etudiant()
    {
        return $this->belongsTo(Etudiant::class);
    }

    public function module()
    {
        return $this->belongsTo(Module::class);
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


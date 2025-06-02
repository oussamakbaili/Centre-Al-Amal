<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seance extends Model
{
    use HasFactory;
    protected $fillable = ['module_id', 'date', 'heure_debut', 'heure_fin'];

    public function module() {
        return $this->belongsTo(Module::class);
    }
}

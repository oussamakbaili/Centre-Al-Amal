<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ['module_id', 'type', 'contenu'];

    public function module()
    {
        return $this->belongsTo(Module::class);
    }
    public function enseignant()
    {
        return $this->belongsTo(Enseignant::class);
    }
}
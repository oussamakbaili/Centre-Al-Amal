<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', // Ajoutez d'autres champs si nécessaire
    ];
    public function admins()
{
    return $this->hasMany(Admin::class);
}
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',      // Corrigé: user-id -> user_id
        'ville_id',     // Corrigé: ville-id -> ville_id
        'commune_id',   // Corrigé: commune-id -> commune_id
        'latitude',
        'longitude',
    ];

    // Relation avec les users
    public function users()
    {
        return $this->hasMany(User::class);
    }

    // Relation avec les produits
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
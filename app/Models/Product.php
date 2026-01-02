<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',       // vendeur
        'category_id',
        'ville_id',
        'commune_id',
        'name',
        'description',
        'prix',
        'image',
        'is_available',
        'is_active',
    ];

    // Relation vers le vendeur
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relation vers la catégorie
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Relation vers la ville
    public function ville()
    {
        return $this->belongsTo(Ville::class);
    }

    // Relation vers la commune
    public function commune()
    {
        return $this->belongsTo(Commune::class);
    }

    // Dans App\Models\Product.php

protected static function booted()
{
    static::addGlobalScope('active', function ($builder) {
        $builder->where('is_active', true)
                ->whereHas('user', function($q) {
                    $q->where('is_open', true);
                });
    });
}
}


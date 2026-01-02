<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Ville;
use App\Models\Commune;

class HomeController extends Controller
{
    public function index()
    {
        // Récupérer les catégories avec le nombre de produits
        $categories = Category::withCount('products')
            ->get()
            ->map(function($category) {
                // Mapper les icônes selon le nom
                $iconMap = [
                    'Plats locaux' => 'utensils',
                    'Fast Food' => 'burger',
                    'Desserts' => 'cake',
                    'Boissons' => 'glass-water',
                    'Petit déjeuner' => 'coffee',
                    'Végétarien' => 'salad',
                    'Pizza' => 'pizza',
                    'Grillades' => 'beef',
                ];

                return (object)[
                    'id' => $category->id,
                    'name' => $category->name,
                    'icon' => $iconMap[$category->name] ?? 'utensils',
                    'products_count' => $category->products_count
                ];
            });

        // Récupérer les produits disponibles avec toutes les relations
        $meals = Product::where('is_available', true)
            ->with(['user', 'category'])
            ->get()
            ->map(function($product) {
                return (object)[
                    'id' => $product->id,
                    'name' => $product->name,
                    'description' => $product->description,
                    'price' => $product->prix, // IMPORTANT: "prix" pas "price"
                    'image' => $product->image,
                    'is_available' => $product->is_available,
                    'vendor_name' => $product->user->name,
                    'vendor_phone' => $product->user->phone ?? '22500000000',
                    'vendor_id' => $product->user->id
                ];
            });

        // Récupérer toutes les villes
        $villes = Ville::orderBy('name')->get();

        // Récupérer toutes les communes
        $communes = Commune::orderBy('name')->get();

        // Récupérer simplement quelques vendeurs de la base de données
        $vendors = User::where('role', 'vendeur')
            ->withCount('products')
            ->with('commune')
            ->inRandomOrder() // Pour varier l'affichage à chaque rechargement
            ->take(12)
            ->get()
            ->map(function($vendor) {
                $vendor->commune_name = $vendor->commune->name ?? 'Non spécifié';
                return $vendor;
            });

        return view('home', compact('vendors', 'categories', 'meals', 'villes', 'communes'));
    }
}

   
    

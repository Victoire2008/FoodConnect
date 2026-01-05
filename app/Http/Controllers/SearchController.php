<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Ville; 
use App\Models\User;
use Illuminate\Support\Facades\DB; // Ajouté pour les requêtes complexes si besoin

class SearchController extends Controller
{
    public function index(Request $request)
    {
        // 1. Récupération des paramètres
        $query      = $request->q;
        $categoryId = $request->category_id;
        $villeId    = $request->ville_id;
        $communeId  = $request->commune_id;

        $villes = Ville::all();
        $categories = Category::all();
        $selectedCategory = $categoryId ? Category::find($categoryId) : null;

        // 2. Construction de la requête
        $mealsQuery = Product::select(
                'products.id',
                'products.name',
                'products.image',
                'products.prix',
                'products.category_id',
                'products.is_available',
                'products.user_id',
                'users.name as vendor_name',
                'users.photo as vendor_photo',
                'users.id as vendor_id'
            )
            ->join('users', 'users.id', '=', 'products.user_id');// <-- FIX : On précise "products."
             // <-- Optionnel : Vérifie si le vendeur est ouvert

        // 3. Application des filtres
        if ($query && strlen($query) >= 2) {
            $mealsQuery->where('products.name', 'LIKE', "%{$query}%");
        }

        if ($categoryId) {
            $mealsQuery->where('products.category_id', $categoryId);
        }

        if ($villeId) {
            $mealsQuery->where('products.ville_id', $villeId);
        }

        if ($communeId) {
            $mealsQuery->where('products.commune_id', $communeId);
        }

        // 4. Exécution
        $meals = $mealsQuery->orderBy('products.created_at', 'desc')->get();

        return view('search', [
            'meals' => $meals,
            'query' => $query,
            'categoryId' => $categoryId,
            'selectedCategory' => $selectedCategory,
            'villes' => $villes,
            'categories' => $categories
        ]);
    }
}
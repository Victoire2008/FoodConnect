<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        // Compter tous les produits
        $productsCount = Product::count();
        
        // Compter les produits sans catégorie
        $pendingProducts = Product::whereNull('category_id')->count();
        
        // Compter les catégories
        $categoriesCount = Category::count();
        
        // Compter les vendeurs
        $vendorsCount = User::where('role', 'vendeur')->count();
        
        // Liste des produits en attente
        $pendingProductsList = Product::whereNull('category_id')
            ->with('user')
            ->get();
        
        // Liste des catégories AVEC le nombre de produits
        $categories = Category::withCount('products')->get();
        
        // Liste des vendeurs avec le nombre de produits
        $vendorsList = User::where('role', 'vendeur')
            ->withCount('products')
            ->get();

        // Liste des produits pour l'affichage
        $products = Product::with('user', 'category')->get();

        return view('admin.dashboard', compact(
            'productsCount',
            'pendingProducts',
            'categoriesCount',
            'vendorsCount',
            'pendingProductsList',
            'categories',
            'vendorsList',
            'products'
        ));
    }
}
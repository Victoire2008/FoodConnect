<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;


class VendeurStoreController extends Controller
{
    public function show($id)
    {
        // 1. On récupère le vendeur et ses infos (ville, photo, bio)
        $vendeur = User::with(['ville', 'commune'])->findOrFail($id);

        // 2. On récupère UNIQUEMENT ses plats à lui
        $plats = Product::where('user_id', $id)
                        ->where('is_available', true)
                        ->latest()
                        ->get();

        // 3. On retourne la vue "vitrine"
        return view('vendeur.store.show', compact('vendeur', 'plats'));
    }
}


<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class VendorController extends Controller
{
    // Liste tous les vendeurs
    public function index()
    {
        // On récupère aussi le compte des produits pour l'afficher dans le dashboard
        $vendors = User::where('role', 'vendeur')->withCount('products')->latest()->get();
        return view('admin.vendors.index', compact('vendors'));
    }

    public function create()
    {
        return view('admin.vendors.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'nullable|string',
            'password' => 'required|min:6',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'role' => 'vendeur',
            'is_active' => true,
            'is_open' => true, // On s'assure qu'il est ouvert par défaut
        ]);

        return redirect()->route('admin.vendors.index')->with('success', 'Le nouveau partenaire a été ajouté avec succès.');
    }

    public function edit(User $vendor)
    {
        // Correction du chemin de la vue (vendors au lieu de vendeurs)
        return view('admin.vendors.edit', compact('vendor'));
    }

    public function update(Request $request, User $vendor)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $vendor->id,
            'phone' => 'nullable',
            'password' => 'nullable|min:6',
        ]);

        $data = $request->only(['name','email','phone']);
        
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $vendor->update($data);

        return redirect()->route('admin.vendors.index')->with('success', 'Informations du vendeur mises à jour.');
    }

    public function destroy(User $vendor)
    {
        // Optionnel : Supprimer ses produits avant le vendeur pour éviter les erreurs SQL
        $vendor->products()->delete();
        $vendor->delete();
        
        return redirect()->route('admin.vendors.index')->with('success', 'Vendeur et ses produits supprimés.');
    }

    /**
     * Basculer l'état du compte (Actif / Suspendu)
     */
   /**
 * Basculer l'état du compte (Actif / Suspendu)
 */
public function toggle(User $vendor) 
{
    // SECURITÉ : On s'assure qu'on travaille sur une instance existante
    if (!$vendor->exists) {
        return back()->with('error', 'Utilisateur introuvable.');
    }

    // On inverse manuellement et on utilise update() pour être sûr que SQL fasse un UPDATE
    $vendor->update([
        'is_active' => !$vendor->is_active
    ]);

    $status = $vendor->is_active ? 'activé' : 'suspendu';
    
    return back()->with('success', "Le compte de {$vendor->name} est maintenant {$status}.");
}

/**
 * Basculer l'état de la boutique (Ouverte / Fermée)
 */
public function toggleOpen(User $vendor)
{
    if (!$vendor->exists) {
        return back()->with('error', 'Boutique introuvable.');
    }

    $vendor->update([
        'is_open' => !$vendor->is_open
    ]);

    $status = $vendor->is_open ? 'ouverte' : 'fermée';

    return back()->with('success', "La boutique de {$vendor->name} est maintenant {$status}.");
}   
}
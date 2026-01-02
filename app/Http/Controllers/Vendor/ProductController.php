<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\ProductService;
use PhpParser\Node\NullableType;
use App\Models\Ville;
use App\Models\Commune;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductService $service)
    {
        // Initialisation du service
        $this->productService = $service;
    }

    /**
     * Affiche tous les produits du vendeur connecté
     */
    public function index()
    {
        $productsCount = Product::where('user_id', Auth::id())->count();
        $products = Product::with('category')
            ->where('user_id', Auth::id())
            ->get();

        return view('vendeur.dashboard', compact('products', 'productsCount'));
    }

    /**
     * Formulaire pour créer un produit
     */
    public function create()
    {
        $categories = Category::all();
        $villes = Ville::all();
        $communes = Commune::all();
        return view('vendeur.products.create', compact('categories', 'villes', 'communes'));
    }

// enregistrer un produit   


   public function store(Request $request)
 {
    try {
        // Validation des données
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'prix' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'ville_id' => 'required|exists:villes,id',
            'commune_id' => 'required|exists:communes,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'nullable|boolean'
        ]);

        // Gestion de l'upload d'image
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        // Création du produit
        $product = Product::create([
            'name' => $validated['name'],
            'prix' => $validated['prix'],
            'description' => $validated['description'] ?? null,
            'category_id' => $validated['category_id'],
            'ville_id' => $validated['ville_id'],
            'commune_id' => $validated['commune_id'],
            'user_id' => auth::id(),
            'image' => $imagePath,
            'is_available' => $request->has('is_active') ? 1 : 0
        ]);

        // Redirection avec message de succès
        return redirect()
            ->route('vendeur.dashboard')
            ->with('success', '✅ Produit ajouté avec succès !');

    } catch (\Exception $e) {
        // En cas d'erreur
        return redirect()
            ->back()
            ->withInput()
            ->with('error', '❌ Erreur lors de l\'ajout du produit : ' . $e->getMessage());
    }
 }
    /**
     * Formulaire pour éditer un produit
     */
    public function edit(Product $product)
    {
        if ($product->user_id !== Auth::id()) abort(403);

        $categories = Category::all();
        return view('vendeur.products.edit', compact('product', 'categories'));
    }

    /**
     * Mettre à jour un produit
     */
  public function update(Request $request, Product $product)
{
    if ($product->user_id !== Auth::id()) abort(403);

    // 1. Validation : On attend 'prix' car c'est le nom dans le HTML
    $request->validate([
        'name' => 'required|string',
        'description' => 'nullable|string',
        'prix' => 'required|numeric', 
        'category_id' => 'required|exists:categories,id',
        'image' => 'nullable|image|max:2048',
    ]);

    // 2. Mise à jour manuelle pour être sûr à 100%
    $product->name = $request->name;
    $product->description = $request->description;
    $product->prix = $request->prix; // Assigne la valeur reçue à la colonne
    $product->category_id = $request->category_id;

    // 3. Gestion des Checkboxes (Toggles)
    $product->is_available = $request->has('is_available') ? 1 : 0;
    $product->is_visible = $request->has('is_visible') ? 1 : 0;

    // 4. Image
    if ($request->hasFile('image')) {
        if ($product->image && Storage::disk('public')->exists($product->image)) {
            Storage::disk('public')->delete($product->image);
        }
        $product->image = $request->file('image')->store('plats', 'public');
    }

    // 5. Sauvegarde et Redirection
    $product->save();

    return redirect()->route('vendeur.dashboard')->with('success', 'Plat mis à jour !');
}
    /**
     * Supprimer un produit
     */
    public function destroy(Product $product)
    {
        if ($product->user_id !== Auth::id()) abort(403);

        $this->productService->delete($product);

        return redirect()->route('vendeur.products.index')
            ->with('success', 'Produit supprimé avec succès');
    }

    /**
     * Générer le lien WhatsApp pour le produit
     */
    public function whatsapp(Product $product)
    {
        if ($product->user_id !== Auth::id()) abort(403);

        $link = $this->productService->whatsapp($product);

        return redirect($link);
    }

    public function toggleStatus(Product $product)
{
    // Sécurité : Vérifier que le plat appartient bien au vendeur connecté
    if ($product->user_id !== auth::id()) {
        abort(403);
    }

    // Bascule entre 1 et 0
    $product->update([
        'is_active' => !$product->is_active
    ]);

    return back()->with('success', 'Statut du plat mis à jour !');
}

public function trackClick(Product $product)
{
    // 1. On incrémente le compteur de clics
    $product->increment('clicks_count');

    // 2. On prépare le message WhatsApp
    $vendor = $product->user;
    $message = "Bonjour " . $vendor->nom . ", je souhaite commander le plat : " . $product->name;
    
    // Nettoyage du numéro de téléphone (enlever espaces ou caractères spéciaux)
    $phone = preg_replace('/[^0-9]/', '', $vendor->phone);

    // 3. Redirection vers l'API WhatsApp
    return redirect("https://wa.me/{$phone}?text=" . urlencode($message));
}
}

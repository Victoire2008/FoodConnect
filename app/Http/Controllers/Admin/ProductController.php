<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class ProductController extends Controller
{
    // Voir tous les produits de tous les vendeurs
    public function index()
    {
        $products = Product::with('user', 'category')->get();
        return view('admin.dashboard', compact('products'));
    }

    // Optionnel : éditer un produit si nécessaire
    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));

    }

    

public function dashboard()
{
    $productsCount = Product::count();
    $pendingProducts = Product::whereNull('category_id')->count();  
    $categoriesCount = Category::count();
    $vendorsCount = User::where('role', 'vendeur')->count();
}


    // Mettre à jour un produit
   public function update(Request $request, Product $product)
{
    // 1. Validation stricte
    $request->validate([
        'name' => 'required|string|max:255',
        'prix' => 'required|numeric',
        'category_id' => 'required|exists:categories,id',
        'description' => 'nullable',
        'image' => 'nullable|image|max:2048',
    ]);

    // 2. Préparation des données
    $data = $request->all();

    // 3. Gérer les Toggles (Checkboxes) explicitement
    // Si la case n'est pas cochée, on force la valeur à 0
    $data['is_available'] = $request->has('is_available') ? 1 : 0;
    $data['is_visible'] = $request->has('is_visible') ? 1 : 0;

    // 4. Gestion de l'image
    if ($request->hasFile('image')) {
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }
        $data['image'] = $request->file('image')->store('products', 'public');
    }

    // 5. Mise à jour et Redirection IMMÉDIATE
    $product->update($data);

    return redirect()->route('admin.dashboard')->with('success', 'Produit mis à jour avec succès !');
}

    // Supprimer un produit (si inapproprié)
    public function destroy(Product $product)
    {
        if ($product->image) Storage::disk('public')->delete($product->image);
        $product->delete();

        return redirect()->route('admin.dashboard')->with('success', 'Produit supprimé');
    }

    // Voir le détail d’un produit et son vendeur
    public function show(Product $product)
    {
        $product->load('user', 'category');
        return view('admin.products.show', compact('product'));
    }

    // Valider un produit
    public function validate(Request $request, Product $product)
    {
        $product->update(['is_available' => true]);

        return redirect()->route('admin.dashboard')->with('success', 'Produit validé');
    }

    public function allProducts()
{
    $products = Product::with('user', 'category')->latest()->get();
    return view('admin.products.index', compact('products'));
}

public function toggleProduct(Product $product)
{
    $product->is_active = !$product->is_active;
    $product->save();

    return back()->with('success', "Le statut du plat '{$product->name}' a été modifié.");
}
}

<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;


class ProductService
{
    /**
     * Créer un produit
     */
  public function create(array $data): Product
{
    if (
        isset($data['image']) &&
        $data['image'] instanceof \Illuminate\Http\UploadedFile
    ) {
        $data['image'] = $data['image']->store('products', 'public');
    }

    return Product::create($data);
}


    /**
     * Mettre à jour un produit
     */
  public function update(Product $product, array $data): Product
{
    if (
        isset($data['image']) &&
        $data['image'] instanceof UploadedFile
    ) {
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $data['image'] = $data['image']->store('products', 'public');
    }

    $product->update($data);
    return $product;
}


    /**
     * Supprimer un produit
     */
    public function delete(Product $product): void
    {
        if ($product->image) Storage::disk('public')->delete($product->image);
        $product->delete();
    }

    /**
     * Générer le lien WhatsApp pour le produit
     */
    public function whatsapp(Product $product): string
    {
        $number = $product->user->phone;
        $message = "Bonjour, je voudrais commander le plat : {$product->name} pour {$product->price} FCFA.";
        return "https://wa.me/{$number}?text=" . urlencode($message);
    }
}

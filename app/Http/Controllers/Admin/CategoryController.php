<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories',
            'description' => 'nullable|string|max:500'
        ]);

        Category::create($request->only('name', 'description'));

        return redirect()->route('admin.dashboard')
            ->with('success', 'Catégorie ajoutée avec succès !');
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
            'description' => 'nullable|string|max:500'
        ]);

        $category->update($request->only('name', 'description'));

        return redirect()->route('admin.dashboard')
            ->with('success', 'Catégorie modifiée avec succès !');
    }

    public function destroy(Category $category)
    {
        // Vérifier si la catégorie a des produits
        if ($category->products()->count() > 0) {
            return redirect()->route('admin.dashboard')
                ->with('error', 'Impossible de supprimer une catégorie qui contient des produits.');
        }

        $category->delete();

        return redirect()->route('admin.dashboard')
            ->with('success', 'Catégorie supprimée avec succès !');
    }
}
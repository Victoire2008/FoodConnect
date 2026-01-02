<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ville;
use Illuminate\Http\Request;

class VilleController extends Controller
{
    public function index()
    {
        $villes = Ville::with('communes')->get();
        return view('admin.villes.index', compact('villes'));
    }

    public function create()
    {
        return view('admin.villes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:villes',
        ]);

        Ville::create($request->all());

        return redirect()->route('admin.villes.index')->with('success', 'Ville ajoutée avec succès');
    }

    public function show(Ville $ville)
    {
        $ville->load('communes');
        return view('admin.villes.show', compact('ville'));
    }

    public function edit(Ville $ville)
    {
        return view('admin.villes.edit', compact('ville'));
    }

    public function update(Request $request, Ville $ville)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:villes,name,' . $ville->id,
        ]);

        $ville->update($request->all());

        return redirect()->route('admin.villes.index')->with('success', 'Ville mise à jour avec succès');
    }

    public function destroy(Ville $ville)
    {
        $ville->delete();

        return redirect()->route('admin.villes.index')->with('success', 'Ville supprimée avec succès');
    }
}

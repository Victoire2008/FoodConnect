<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Commune;
use App\Models\Ville;
use Illuminate\Http\Request;

class CommuneController extends Controller
{
    public function index()
    {
        $communes = Commune::with('ville')->get();
        return view('admin.communes.index', compact('communes'));
    }

    public function create()
    {
        $villes = Ville::all();
        return view('admin.communes.create', compact('villes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'ville_id' => 'required|exists:villes,id',
        ]);

        Commune::create($request->all());

        return redirect()->route('admin.communes.index')->with('success', 'Commune ajoutée avec succès');
    }

    public function show(Commune $commune)
    {
        $commune->load('ville');
        return view('admin.communes.show', compact('commune'));
    }

    public function edit(Commune $commune)
    {
        $villes = Ville::all();
        return view('admin.communes.edit', compact('commune', 'villes'));
    }

    public function update(Request $request, Commune $commune)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'ville_id' => 'required|exists:villes,id',
        ]);

        $commune->update($request->all());

        return redirect()->route('admin.communes.index')->with('success', 'Commune mise à jour avec succès');
    }

    public function destroy(Commune $commune)
    {
        $commune->delete();

        return redirect()->route('admin.communes.index')->with('success', 'Commune supprimée avec succès');
    }
}

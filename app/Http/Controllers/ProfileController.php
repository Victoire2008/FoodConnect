<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Ville;
use App\Models\Commune;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\User;
use App\Models\Product;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
            'villes' => Ville::all(),
            'communes' => Commune::all(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
  public function update(Request $request)
{
    $user = $request->user();

    $validated = $request->validate([
        'nom' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email,'.$user->id],
        'phone' => ['nullable', 'string', 'max:20'], // On valide 'phone'
        'ville_id' => ['nullable', 'exists:villes,id'],
        'commune_id' => ['nullable', 'exists:communes,id'],
        'bio' => ['nullable', 'string'],
        'photo' => ['nullable', 'image', 'max:2048'],
    ]);

    // Remplissage automatique des champs validés
    $user->fill($validated);

    // Si tu as changé l'email, on réinitialise la vérification
    if ($user->isDirty('email')) {
        $user->email_verified_at = null;
    }

    // Gestion de la photo si présente
    if ($request->hasFile('photo')) {
        $user->photo = $request->file('photo')->store('profile-photos', 'public');
    }

    $user->save();

    return Redirect::route('vendeur.profile.edit')->with('status', 'profile-updated');
}


    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}

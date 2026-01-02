@extends('layoutts.vendor')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-orange-50 via-white to-orange-50 py-12 px-4">
    <div class="max-w-3xl mx-auto">
        <!-- Messages de succès/erreur -->
        @if(session('success'))
            <div class="mb-6 bg-green-50 border-2 border-green-200 rounded-xl p-4 flex items-center gap-3 animate-fade-in">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-green-600 flex-shrink-0">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                    <polyline points="22 4 12 14.01 9 11.01"/>
                </svg>
                <span class="text-green-800 font-medium">{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 bg-red-50 border-2 border-red-200 rounded-xl p-4 flex items-center gap-3 animate-fade-in">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-red-600 flex-shrink-0">
                    <circle cx="12" cy="12" r="10"/>
                    <line x1="15" x2="9" y1="9" y2="15"/>
                    <line x1="9" x2="15" y1="9" y2="15"/>
                </svg>
                <span class="text-red-800 font-medium">{{ session('error') }}</span>
            </div>
        @endif

        @if($errors->any())
            <div class="mb-6 bg-red-50 border-2 border-red-200 rounded-xl p-4">
                <div class="flex items-center gap-3 mb-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-red-600">
                        <circle cx="12" cy="12" r="10"/>
                        <line x1="12" x2="12" y1="8" y2="12"/>
                        <line x1="12" x2="12.01" y1="16" y2="16"/>
                    </svg>
                    <span class="text-red-800 font-semibold">Erreurs de validation :</span>
                </div>
                <ul class="list-disc list-inside text-red-700 space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- En-tête -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-orange-500 rounded-2xl mb-4 shadow-lg">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M3 9h18v10a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V9Z"/>
                    <path d="m3 9 2.45-4.9A2 2 0 0 1 7.24 3h9.52a2 2 0 0 1 1.8 1.1L21 9"/>
                    <path d="M12 3v6"/>
                </svg>
            </div>
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Ajouter un nouveau produit</h1>
            <p class="text-gray-600">Remplissez les informations pour ajouter votre plat</p>
        </div>

        <!-- Formulaire -->
        <form method="POST" action="{{ route('vendeur.products.store') }}" enctype="multipart/form-data" id="productForm"
              class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
            @csrf

            <div class="p-8 space-y-6">
                <!-- Nom du produit -->
                <div>
                    <label class="flex items-center gap-2 mb-2 text-sm font-semibold text-gray-700">
                        Nom du produit
                    </label>
                    <input type="text" name="name" value="{{ old('name') }}"
                           placeholder="Ex: Attiéké Poisson"
                           class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:border-orange-500 focus:ring-4 focus:ring-orange-100 transition-all @error('name') border-red-500 @enderror"
                           required>
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Prix -->
                <div>
                    <label class="flex items-center gap-2 mb-2 text-sm font-semibold text-gray-700">
                        Prix (FCFA)
                    </label>
                    <div class="relative">
                        <input type="number" name="prix" value="{{ old('prix') }}"
                               placeholder="1500"
                               class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 pr-20 focus:outline-none focus:border-orange-500 focus:ring-4 focus:ring-orange-100 transition-all @error('prix') border-red-500 @enderror"
                               required>
                        <span class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-500 font-medium">FCFA</span>
                    </div>
                    @error('prix')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div>
                    <label class="block mb-1 font-semibold text-gray-700">Description</label>
                    <textarea name="description" rows="4"
                              placeholder="Décrivez votre plat, ses ingrédients, sa préparation..."
                              class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:border-orange-500 focus:ring-4 focus:ring-orange-100 transition-all resize-none @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Catégorie -->
                <div>
                    <label class="block mb-1 font-semibold text-gray-700">Catégorie</label>
                    <select name="category_id"
                            class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 bg-white focus:outline-none focus:border-orange-500 focus:ring-4 focus:ring-orange-100 transition-all cursor-pointer @error('category_id') border-red-500 @enderror"
                            required>
                        <option value="">Sélectionner une catégorie</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Ville -->
                <div>
                    <label class="block mb-1 font-semibold text-gray-700">Ville</label>
                    <select name="ville_id"
                            class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 bg-white focus:outline-none focus:border-orange-500 focus:ring-4 focus:ring-orange-100 transition-all cursor-pointer @error('ville_id') border-red-500 @enderror"
                            required>
                        <option value="">Sélectionner une ville</option>
                        @foreach($villes as $ville)
                            <option value="{{ $ville->id }}" {{ old('ville_id') == $ville->id ? 'selected' : '' }}>
                                {{ $ville->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('ville_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Commune -->
                <div>
                    <label class="block mb-1 font-semibold text-gray-700">Commune</label>
                    <select name="commune_id"
                            class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 bg-white focus:outline-none focus:border-orange-500 focus:ring-4 focus:ring-orange-100 transition-all cursor-pointer @error('commune_id') border-red-500 @enderror"
                            required>
                        <option value="">Sélectionner une commune</option>
                        @foreach($communes as $commune)
                            <option value="{{ $commune->id }}" {{ old('commune_id') == $commune->id ? 'selected' : '' }}>
                                {{ $commune->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('commune_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Image -->
                <div>
                    <label class="block mb-1 font-semibold text-gray-700">Image du produit</label>
                    <div class="relative">
                        <input type="file" name="image" accept="image/*" id="imageInput" class="hidden">
                        <label for="imageInput" 
                               class="flex items-center justify-center gap-3 w-full border-2 border-dashed border-gray-300 rounded-xl px-4 py-8 cursor-pointer hover:border-orange-500 hover:bg-orange-50 transition-all group">
                            Cliquez pour choisir une image
                        </label>
                        <div id="imagePreview" class="mt-4 hidden">
                            <img src="" alt="Aperçu" class="w-full h-48 object-cover rounded-xl border-2 border-gray-200">
                        </div>
                    </div>
                    @error('image')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Statut -->
                <div class="bg-orange-50 border-2 border-orange-100 rounded-xl p-4">
                    <label class="flex items-center gap-3 cursor-pointer group">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}
                               class="w-5 h-5 rounded border-2 border-orange-300 text-orange-500 focus:ring-4 focus:ring-orange-200 cursor-pointer">
                        <span class="text-sm font-semibold text-gray-700 group-hover:text-orange-600 transition">
                            Produit actif et disponible à la vente
                        </span>
                    </label>
                </div>
            </div>

            <!-- Actions -->
            <div class="bg-gray-50 px-8 py-6 border-t border-gray-100 flex gap-4">
                <button type="submit" id="submitBtn"
                        class="flex-1 bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white font-semibold px-6 py-3 rounded-xl transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 flex items-center justify-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed">
                    <span id="submitText">Enregistrer le produit</span>
                </button>
                <a href="{{ route('vendeur.dashboard') }}"
                   class="px-6 py-3 rounded-xl border-2 border-gray-300 text-gray-700 font-semibold hover:bg-gray-100 hover:border-gray-400 transition-all flex items-center gap-2">
                    Annuler
                </a>
            </div>
        </form>
    </div>
</div>

<style>
@keyframes fade-in {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}
.animate-fade-in { animation: fade-in 0.3s ease-out; }
</style>

<script>
document.getElementById('imageInput').addEventListener('change', function(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById('imagePreview');
            const img = preview.querySelector('img');
            img.src = e.target.result;
            preview.classList.remove('hidden');
        };
        reader.readAsDataURL(file);
    }
});
</script>

@endsection
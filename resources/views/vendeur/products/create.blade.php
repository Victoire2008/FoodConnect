@extends('layouts.vendor')

@section('content')
<div class="min-h-screen bg-[#fffcf9] py-8 md:py-12 px-4">
    <div class="max-w-3xl mx-auto">
        
        {{-- Bouton Retour & Titre --}}
        <div class="mb-10">
            <a href="{{ route('vendeur.dashboard') }}" class="inline-flex items-center gap-2 text-gray-400 hover:text-orange-500 transition-colors font-bold text-xs uppercase tracking-widest mb-4">
                <i data-lucide="chevron-left" class="w-4 h-4"></i>
                Retour au tableau de bord
            </a>
            <h1 class="text-3xl md:text-4xl font-black text-gray-900 leading-tight">Nouveau délice <span class="text-orange-500">.</span></h1>
            <p class="text-gray-500 font-medium mt-2">Partagez votre passion culinaire avec le monde.</p>
        </div>

        {{-- Affichage des erreurs globales --}}
        @if($errors->any())
            <div class="mb-8 bg-red-50 border-l-4 border-red-500 p-4 rounded-2xl animate-fade-in">
                <div class="flex items-center gap-3">
                    <i data-lucide="alert-circle" class="text-red-500"></i>
                    <p class="text-red-800 font-bold">Veuillez vérifier les champs du formulaire.</p>
                </div>
            </div>
        @endif

        <form method="POST" action="{{ route('vendeur.products.store') }}" enctype="multipart/form-data" id="productForm" class="space-y-6">
            @csrf

            {{-- SECTION IMAGE --}}
            <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-gray-100">
                <label class="block text-xs font-black uppercase tracking-widest text-gray-400 mb-6">Photo du plat</label>
                
                <div class="flex flex-col items-center">
                    <div id="dropzone" class="relative group w-full max-w-sm h-64 rounded-[2.5rem] overflow-hidden bg-gray-50 border-2 border-dashed border-gray-200 hover:border-orange-400 transition-all flex items-center justify-center cursor-pointer">
                        <input type="file" name="image" id="imageInput" class="hidden" accept="image/*" required>
                        
                        <div id="placeholder-content" class="text-center p-6">
                            <div class="w-16 h-16 bg-orange-100 text-orange-600 rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform">
                                <i data-lucide="image-plus" class="w-8 h-8"></i>
                            </div>
                            <p class="text-gray-600 font-bold">Cliquez pour ajouter une photo</p>
                            <p class="text-xs text-gray-400 mt-2 italic">Format recommandé : Carré (1:1)</p>
                        </div>

                        <div id="imagePreview" class="absolute inset-0 hidden">
                            <img src="" class="w-full h-full object-cover">
                            <div class="absolute inset-0 bg-black/20 group-hover:bg-black/40 transition-colors flex items-center justify-center opacity-0 group-hover:opacity-100">
                                <p class="text-white font-bold flex items-center gap-2"><i data-lucide="refresh-cw" class="w-4 h-4"></i> Changer la photo</p>
                            </div>
                        </div>
                    </div>
                    @error('image') <p class="text-red-500 text-xs mt-3 font-bold">{{ $message }}</p> @enderror
                </div>
            </div>

            {{-- SECTION INFOS GÉNÉRALES --}}
            <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-gray-100 space-y-6">
                {{-- Nom du produit --}}
                <div>
                    <label class="block text-xs font-black uppercase tracking-widest text-gray-400 mb-2 ml-1">Nom du produit</label>
                    <input type="text" name="name" value="{{ old('name') }}"
                           placeholder="Ex: Garba Spécial Ivoirien"
                           class="w-full px-6 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-orange-500 font-bold text-gray-800 placeholder:text-gray-300 transition-all"
                           required>
                    @error('name') <p class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</p> @enderror
                </div>

                {{-- Prix --}}
                <div>
                    <label class="block text-xs font-black uppercase tracking-widest text-gray-400 mb-2 ml-1">Prix de vente</label>
                    <div class="relative">
                        <input type="number" name="prix" value="{{ old('prix') }}"
                               placeholder="1500"
                               class="w-full px-6 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-orange-500 font-black text-gray-800 text-xl"
                               required>
                        <span class="absolute right-6 top-1/2 -translate-y-1/2 text-orange-500 font-black uppercase text-sm">FCFA</span>
                    </div>
                    @error('prix') <p class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</p> @enderror
                </div>

                {{-- Catégorie --}}
                <div>
                    <label class="block text-xs font-black uppercase tracking-widest text-gray-400 mb-2 ml-1">Catégorie</label>
                    <div class="relative">
                        <select name="category_id" class="w-full px-6 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-orange-500 font-bold text-gray-800 appearance-none cursor-pointer" required>
                            <option value="" disabled selected>Choisir une catégorie...</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        <div class="absolute right-6 top-1/2 -translate-y-1/2 pointer-events-none text-gray-400">
                            <i data-lucide="chevron-down" class="w-5 h-5"></i>
                        </div>
                    </div>
                </div>
            </div>

            {{-- LOCALISATION --}}
            <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-gray-100">
                <label class="block text-xs font-black uppercase tracking-widest text-gray-400 mb-6">Zone de livraison</label>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-bold text-gray-600 mb-2 ml-1">Ville</label>
                        <select name="ville_id" class="w-full px-6 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-orange-500 font-bold text-gray-800 appearance-none cursor-pointer" required>
                            <option value="">Sélectionner</option>
                            @foreach($villes as $ville)
                                <option value="{{ $ville->id }}" {{ old('ville_id') == $ville->id ? 'selected' : '' }}>{{ $ville->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-600 mb-2 ml-1">Commune</label>
                        <select name="commune_id" class="w-full px-6 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-orange-500 font-bold text-gray-800 appearance-none cursor-pointer" required>
                            <option value="">Sélectionner</option>
                            @foreach($communes as $commune)
                                <option value="{{ $commune->id }}" {{ old('commune_id') == $commune->id ? 'selected' : '' }}>{{ $commune->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            {{-- DESCRIPTION --}}
            <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-gray-100">
                <label class="block text-xs font-black uppercase tracking-widest text-gray-400 mb-2 ml-1">Description (Optionnel)</label>
                <textarea name="description" rows="4" 
                          placeholder="Parlez-nous de votre plat : ingrédients secrets, temps de préparation..."
                          class="w-full px-6 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-orange-500 font-medium text-gray-700 resize-none">{{ old('description') }}</textarea>
            </div>

            {{-- DISPONIBILITÉ --}}
            <div class="bg-orange-500 p-6 rounded-[2.5rem] shadow-lg shadow-orange-100 flex items-center justify-between">
                <div class="flex items-center gap-4 text-white">
                    <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center">
                        <i data-lucide="check-circle" class="w-6 h-6"></i>
                    </div>
                    <div>
                        <p class="font-black text-sm uppercase">Mettre en ligne</p>
                        <p class="text-[10px] text-orange-100 font-bold">Le produit sera visible immédiatement.</p>
                    </div>
                </div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} class="sr-only peer">
                    <div class="w-14 h-8 bg-orange-600 rounded-full peer peer-checked:bg-white after:content-[''] after:absolute after:top-[4px] after:left-[4px] after:bg-orange-400 peer-checked:after:bg-orange-500 after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:after:translate-x-6 shadow-inner"></div>
                </label>
            </div>

            {{-- BOUTONS --}}
            <div class="flex flex-col md:flex-row gap-4 pt-6">
                <button type="submit" id="submitBtn" class="flex-[2] py-5 bg-gray-900 text-white rounded-[2rem] font-black text-lg hover:bg-orange-600 transition-all shadow-xl shadow-gray-200 flex items-center justify-center gap-3">
                    <i data-lucide="plus-circle" class="w-6 h-6"></i>
                    Créer le plat maintenant
                </button>
                <a href="{{ route('vendeur.dashboard') }}" class="flex-1 py-5 bg-white border border-gray-100 text-gray-400 rounded-[2rem] font-bold text-center hover:bg-gray-50 transition-colors">
                    Annuler
                </a>
            </div>
        </form>
    </div>
</div>

<script>
    // Preview de l'image amélioré
    const imageInput = document.getElementById('imageInput');
    const dropzone = document.getElementById('dropzone');
    const imagePreview = document.getElementById('imagePreview');
    const placeholder = document.getElementById('placeholder-content');

    dropzone.onclick = () => imageInput.click();

    imageInput.addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                imagePreview.querySelector('img').src = e.target.result;
                imagePreview.classList.remove('hidden');
                placeholder.classList.add('hidden');
                dropzone.classList.add('border-solid', 'border-orange-500');
            }
            reader.readAsDataURL(file);
        }
    });
</script>
@endsection
@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-[#fffcf9] py-12">
    <div class="max-w-3xl mx-auto px-6">
        
        {{-- Retour et Titre --}}
        <div class="flex items-center justify-between mb-10">
            <a href="{{ route('vendeur.dashboard') }}" class="flex items-center gap-2 text-gray-500 hover:text-orange-500 transition-colors font-semibold text-sm">
                <i data-lucide="arrow-left" class="w-4 h-4"></i>
                Retour au dashboard
            </a>
            <h1 class="text-2xl font-black text-gray-900">Modifier le plat</h1>
        </div>

        <form action="{{ route('vendeur.products.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
            @csrf
            @method('PUT')

            {{-- SECTION IMAGE --}}
            <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-gray-100">
                <label class="block text-sm font-bold text-gray-700 mb-4">Photo du plat</label>
                <div class="flex flex-col md:flex-row gap-6 items-center">
                    <div class="w-40 h-40 rounded-[2rem] overflow-hidden bg-gray-100 border-2 border-dashed border-gray-200">
                        <img id="preview" src="{{ asset('storage/' . $product->image) }}" class="w-full h-full object-cover">
                    </div>
                    <div class="flex-1">
                        <input type="file" name="image" id="image-input" class="hidden" accept="image/*">
                        <label for="image-input" class="inline-flex items-center gap-2 px-6 py-3 bg-orange-50 text-orange-600 rounded-xl font-bold cursor-pointer hover:bg-orange-100 transition-all">
                            <i data-lucide="camera" class="w-5 h-5"></i>
                            Changer la photo
                        </label>
                        <p class="text-xs text-gray-400 mt-2 italic">Format recommandé : Carré (1:1), max 2Mo</p>
                    </div>
                </div>
            </div>

            {{-- SECTION INFOS GÉNÉRALES --}}
            <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-gray-100 space-y-6">
                {{-- Nom du plat --}}
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Nom du délice</label>
                    <input type="text" name="name" value="{{ old('name', $product->name) }}"
                           class="w-full px-5 py-4 bg-gray-50 border border-gray-100 rounded-2xl outline-none focus:ring-2 focus:ring-orange-500 font-medium"
                           placeholder="Ex: Garba Royal, Alloco simple...">
                </div>

                {{-- Prix --}}
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Prix (FCFA)</label>
                    <div class="relative">
                        <input type="number" name="prix" value="{{ old('prix', $product->prix) }}"
                               class="w-full px-5 py-4 bg-gray-50 border border-gray-100 rounded-2xl outline-none focus:ring-2 focus:ring-orange-500 font-black">
                        <span class="absolute right-5 top-1/2 -translate-y-1/2 text-orange-500 font-bold">FCFA</span>
                    </div>
                </div>

                {{-- Catégorie --}}
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Catégorie</label>
                    <select name="category_id" class="w-full px-5 py-4 bg-gray-50 border border-gray-100 rounded-2xl outline-none focus:ring-2 focus:ring-orange-500 font-medium">
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- SECTION STATUT (Disponibilité & Visibilité) --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                {{-- Toggle Disponibilité --}}
                <div class="bg-white p-6 rounded-[2rem] border border-gray-100 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <i data-lucide="chef-hat" class="w-5 h-5 text-orange-500"></i>
                        <span class="font-bold text-gray-700">Disponible</span>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="is_available" value="1" {{ $product->is_available ? 'checked' : '' }} class="sr-only peer">
                        <div class="w-11 h-6 bg-gray-200 rounded-full peer peer-checked:bg-green-500 after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:after:translate-x-full"></div>
                    </label>
                </div>

                {{-- Toggle Visibilité --}}
                <div class="bg-white p-6 rounded-[2rem] border border-gray-100 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <i data-lucide="eye" class="w-5 h-5 text-gray-400"></i>
                        <span class="font-bold text-gray-700">Afficher</span>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="is_visible" value="1" {{ $product->is_visible ? 'checked' : '' }} class="sr-only peer">
                        <div class="w-11 h-6 bg-gray-200 rounded-full peer peer-checked:bg-blue-500 after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:after:translate-x-full"></div>
                    </label>
                </div>
            </div>

            {{-- Bouton de Validation --}}
            <button type="submit" class="w-full py-5 bg-gray-900 text-white rounded-[2rem] font-black text-lg hover:bg-orange-600 transition-all shadow-xl shadow-gray-200">
                Enregistrer les modifications
            </button>
        </form>
    </div>
</div>

<script>
    // Aperçu de l'image en temps réel
    document.getElementById('image-input').onchange = evt => {
        const [file] = evt.target.files;
        if (file) {
            document.getElementById('preview').src = URL.createObjectURL(file);
        }
    }
</script>
@endsection

@extends('layoutts.show')

@section('content')

<style>
    .food-bg {
        background-color: #fffaf5; /* Un blanc cassé/crème chaleureux */
        background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M30 30c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm15 15c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zM15 15c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2z' fill='%23f97316' fill-opacity='0.05' fill-rule='evenodd'/%3E%3C/svg%3E");
    }
</style>

<div class="food-bg min-h-screen pb-24">
        {{-- BARRE DE RECHERCHE DYNAMIQUE --}}
<div class="bg-white/80 backdrop-blur-md border-b border-orange-100 py-8 sticky top-0 z-30 shadow-sm">
    <div class="max-w-7xl mx-auto px-6">
        
        <form action="{{ route('search') }}" method="GET" id="search-form"
              class="grid !grid grid-cols-1 md:grid-cols-5 gap-4 items-center">

            {{-- Recherche texte --}}
            <div class="relative w-full">
                <i data-lucide="search"
                   class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400"></i>

                <input type="text" name="q" value="{{ request('q') }}"
                       placeholder="Ex: Garba, Burger..."
                       class="w-full pl-10 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl 
                              focus:ring-2 focus:ring-orange-500 outline-none transition-all">
            </div>

            {{-- Villes --}}
            <div>
                <select name="ville_id" id="ville-select"
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl outline-none 
                               focus:ring-2 focus:ring-orange-500">
                    <option value="">Toute la Côte d'Ivoire</option>
                    @foreach($villes as $ville)
                        <option value="{{ $ville->id }}" {{ request('ville_id') == $ville->id ? 'selected' : '' }}>
                            {{ $ville->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Communes --}}
            <div>
                <select name="commune_id" id="commune-select"
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl outline-none 
                               focus:ring-2 focus:ring-orange-500 {{ !request('ville_id') ? 'opacity-50' : '' }}">
                    <option value="">Toutes les communes</option>
                    @if(isset($communes))
                        @foreach($communes as $commune)
                            <option value="{{ $commune->id }}" {{ request('commune_id') == $commune->id ? 'selected' : '' }}>
                                {{ $commune->name }}
                            </option>
                        @endforeach
                    @endif
                </select>
            </div>

            {{-- Catégories --}}
            <div>
                <select name="category_id"
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl outline-none 
                               focus:ring-2 focus:ring-orange-500">
                    <option value="">Toutes les catégories</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Bouton --}}
            <div>
                <button type="submit"
                        class="w-full bg-orange-500 hover:bg-orange-600 text-white font-bold py-3 rounded-xl 
                               transition-all flex items-center justify-center gap-2 shadow-lg shadow-orange-100">
                    <i data-lucide="sliders-horizontal" class="w-5 h-5"></i>
                    Filtrer
                </button>
            </div>

        </form>
    </div>
</div>


  <section class="max-w-7xl mx-auto px-6 mt-12 mb-24">

    {{-- TITRE DYNAMIQUE --}}
    <div class="flex items-center gap-3 mb-8">
        <div class="h-10 w-1.5 bg-orange-500 rounded-full"></div>
        <h1 class="text-3xl font-bold text-gray-900">
            @if($query && $selectedCategory)
                Résultats pour <span class="text-orange-500">"{{ $query }}"</span> en <span class="text-orange-500">{{ $selectedCategory->name }}</span>
            @elseif($query)
                Résultats pour <span class="text-orange-500">"{{ $query }}"</span>
            @elseif($selectedCategory)
                Catégorie <span class="text-orange-500">{{ $selectedCategory->name }}</span>
            @else
                Tous les <span class="text-orange-500">plats disponibles</span>
            @endif
        </h1>
    </div>

    @if($meals->count())
        {{-- GRID PLATS --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($meals as $meal)
                <div class="bg-white border border-gray-100 shadow-sm rounded-2xl hover:shadow-xl transition-all overflow-hidden flex flex-col">
                    
                    {{-- IMAGE + PRIX --}}
                    <div class="relative h-52 overflow-hidden">
                        <img src="{{ $meal->image ? asset('storage/' . $meal->image) : 'https://images.unsplash.com/photo-1565299624946-b28f40a0ca4b?w=400' }}"
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                             alt="{{ $meal->name }}" />

                        {{-- Étiquette PRIX --}}
                        <div class="absolute top-3 right-3 bg-white/95 backdrop-blur-sm px-4 py-2 rounded-2xl font-black text-gray-900 shadow-lg border border-orange-50 z-10">
                            @php $valeurPrix = $meal->price ?? $meal->prix ?? 0; @endphp
                            {{ number_format($valeurPrix, 0, ',', ' ') }} 
                            <span class="text-orange-500 text-[10px] ml-1">FCFA</span>
                        </div>

                        @if(!$meal->is_available)
                            <div class="absolute inset-0 bg-black/60 flex items-center justify-center z-20">
                                <span class="bg-red-500 text-white px-6 py-2 rounded-full text-xs font-bold uppercase tracking-widest">Indisponible</span>
                            </div>
                        @endif
                    </div>

                    {{-- INFOS DU PLAT --}}
                    <div class="px-3 py-4 flex flex-col flex-1 justify-between">
                        <div>
                            <h3 class="text-lg font-bold text-gray-900 mb-2 truncate">{{ $meal->name }}</h3>

                            {{-- Lien vers la boutique --}}
                            <a href="{{ route('vendeur.store.show', $meal->vendor_id) }}" class="flex items-center gap-2 mb-4 group/vendor">
                                <div class="w-6 h-6 rounded-full overflow-hidden bg-orange-100">
                                    <img src="{{ $meal->vendor_photo ? asset('storage/' . $meal->vendor_photo) : 'https://ui-avatars.com/api/?name='.$meal->vendor_name }}" class="w-full h-full object-cover">
                                </div>
                                <span class="text-xs font-medium text-gray-500 group-hover/vendor:text-orange-500 transition-colors">{{ $meal->vendor_name }}</span>
                            </a>
                        </div>

                        {{-- BOUTONS --}}
                        <div class="flex flex-col gap-2 mt-auto">
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $meal->vendor_phone ?? '22500000000') }}?text={{ urlencode('Bonjour ' . ($meal->vendor_name ?? '') . ', je souhaite commander le plat : ' . ($meal->name ?? '')) }}"
                               target="_blank"
                               class="w-full py-3.5 bg-[#25D366] hover:bg-[#128C7E] text-white rounded-2xl font-bold flex items-center justify-center gap-2 transition-all duration-300 shadow-lg shadow-green-100">
                                <i data-lucide="message-circle" class="w-5 h-5"></i>
                                <span>Commander</span>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        {{-- ÉTAT VIDE --}}
        <div class="text-center py-20 bg-white rounded-3xl border border-dashed border-gray-200 max-w-2xl mx-auto">
            <div class="bg-orange-50 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6">
                <i data-lucide="search-x" class="w-10 h-10 text-orange-500"></i>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-2">Oups ! Aucun plat trouvé</h3>
            <p class="text-gray-500 mb-8 px-6">
                Nous n'avons trouvé aucun résultat pour cette recherche. Essayez de modifier vos filtres ou explorez une autre ville.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center px-6">
                <a href="{{ route('search') }}" class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold rounded-xl transition-all">
                    <i data-lucide="rotate-ccw" class="w-5 h-5"></i> Réinitialiser
                </a>
                <a href="{{ route('home') }}" class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-orange-500 hover:bg-orange-600 text-white font-semibold rounded-xl transition-all shadow-lg shadow-orange-100">
                    <i data-lucide="home" class="w-5 h-5"></i> Page d'accueil
                </a>
            </div>
        </div>
    @endif
</section>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialiser Lucide
        lucide.createIcons(); 

        // Gestion dynamique des communes
        const villeSelect = document.getElementById('ville-select');
        const communeSelect = document.getElementById('commune-select');

        villeSelect.addEventListener('change', function() {
            const villeId = this.value;
            
            communeSelect.innerHTML = '<option value="">Chargement...</option>';
            communeSelect.classList.add('opacity-50');

            if (!villeId) {
                communeSelect.innerHTML = '<option value="">Toutes les communes</option>';
                communeSelect.classList.add('opacity-50');
                return;
            }

            fetch(`/api/villes/${villeId}/communes`)
                .then(response => response.json())
                .then(data => {
                    communeSelect.innerHTML = '<option value="">Toutes les communes</option>';
                    data.forEach(commune => {
                        communeSelect.innerHTML += `<option value="${commune.id}">${commune.name}</option>`;
                    });
                    communeSelect.classList.remove('opacity-50');
                })
                .catch(error => {
                    console.error('Erreur:', error);
                    communeSelect.innerHTML = '<option value="">Erreur de chargement</option>';
                });
        });
    });
</script>
@endsection
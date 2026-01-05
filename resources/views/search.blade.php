@extends('layoutts.show')

@section('content')

<style>
    .food-bg {
        background-color: #fffaf5;
        background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M30 30c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm15 15c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zM15 15c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2z' fill='%23f97316' fill-opacity='0.05' fill-rule='evenodd'/%3E%3C/svg%3E");
    }
</style>

<div class="food-bg min-h-screen pb-24">
    {{-- BARRE DE RECHERCHE DYNAMIQUE --}}
    <div class="bg-white/80 backdrop-blur-md border-b border-orange-100 py-4 md:py-8 sticky top-0 z-30 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 md:px-6">
            {{-- Changement ici : grid-cols-1 par défaut, md:grid-cols-5 pour le desktop --}}
            <form action="{{ route('search') }}" method="GET" id="search-form" class="grid grid-cols-1 md:grid-cols-5 gap-3 md:gap-4">
                
                <div class="relative">
                    <i data-lucide="search" class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400"></i>
                    <input type="text" name="q" value="{{ request('q') }}" 
                           placeholder="Ex: Garba, Burger..."
                           class="w-full pl-10 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 outline-none transition-all text-sm md:text-base">
                </div>

                <select name="ville_id" id="ville-select" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl outline-none focus:ring-2 focus:ring-orange-500 text-sm md:text-base">
                    <option value="">Toute la côte d'ivoire</option>
                    @foreach($villes as $ville)
                        <option value="{{ $ville->id }}" {{ request('ville_id') == $ville->id ? 'selected' : '' }}>{{ $ville->name }}</option>
                    @endforeach
                </select>

                <select name="commune_id" id="commune-select" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl outline-none focus:ring-2 focus:ring-orange-500 text-sm md:text-base {{ !request('ville_id') ? 'opacity-50' : '' }}">
                    <option value="">Toutes les communes</option>
                    @if(isset($communes))
                        @foreach($communes as $commune)
                            <option value="{{ $commune->id }}" {{ request('commune_id') == $commune->id ? 'selected' : '' }}>{{ $commune->name }}</option>
                        @endforeach
                    @endif
                </select>

                <select name="category_id" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl outline-none focus:ring-2 focus:ring-orange-500 text-sm md:text-base">
                    <option value="">Toutes les catégories</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>

                <button type="submit" class="bg-orange-500 hover:bg-orange-600 text-white font-bold py-3 rounded-xl transition-all flex items-center justify-center gap-2 shadow-lg shadow-orange-100 active:scale-95">
                    <i data-lucide="sliders-horizontal" class="w-5 h-5"></i> Filtrer
                </button>
            </form>
        </div>
    </div>

    <section class="max-w-7xl mx-auto px-4 md:px-6 mt-8 md:mt-12 mb-24">
        {{-- TITRE DYNAMIQUE --}}
        <div class="flex items-center gap-3 mb-6 md:mb-8">
            <div class="h-8 md:h-10 w-1.5 bg-orange-500 rounded-full"></div>
            <h1 class="text-xl md:text-3xl font-bold text-gray-900 leading-tight">
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
            {{-- Grid responsive : 1 col mobile, 2 col sm, 3 col md, 4 col lg --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6">
                @foreach($meals as $meal)
                    <div class="bg-white border border-gray-100 shadow-sm rounded-[2rem] md:rounded-[2.5rem] hover:shadow-xl transition-all overflow-hidden group p-3">
                        {{-- Conteneur Image + Prix --}}
                        <div class="relative h-48 md:h-52 overflow-hidden rounded-[1.8rem] md:rounded-[2rem] mb-4">
                            <img src="{{ $meal->image ? asset('storage/' . $meal->image) : 'https://images.unsplash.com/photo-1565299624946-b28f40a0ca4b?w=400' }}"
                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                                 alt="{{ $meal->name }}" />
                            
                            <div class="absolute top-3 right-3 bg-white/95 backdrop-blur-sm px-3 py-1.5 md:px-4 md:py-2 rounded-2xl font-black text-gray-900 shadow-lg border border-orange-50 z-10 text-sm md:text-base">
                                @php $valeurPrix = $meal->price ?? $meal->prix ?? 0; @endphp
                                {{ number_format($valeurPrix, 0, ',', ' ') }} 
                                <span class="text-orange-500 text-[10px] ml-1">FCFA</span>
                            </div>

                            @if(!$meal->is_available)
                                <div class="absolute inset-0 bg-black/60 backdrop-blur-[2px] flex items-center justify-center z-20">
                                    <span class="bg-red-500 text-white px-6 py-2 rounded-full text-xs font-bold uppercase tracking-widest">Indisponible</span>
                                </div>
                            @endif
                        </div>

                        {{-- Infos du Plat --}}
                        <div class="px-2 md:px-3 pb-2">
                            <h3 class="text-base md:text-lg font-bold text-gray-900 mb-1 truncate">{{ $meal->name }}</h3>
                            
                            <a href="{{ route('vendeur.store.show', $meal->vendor_id) }}" class="flex items-center gap-2 mb-4 group/vendor">
                                <div class="w-6 h-6 rounded-full overflow-hidden bg-orange-100">
                                    <img src="{{ $meal->vendor_photo ? asset('storage/' . $meal->vendor_photo) : 'https://ui-avatars.com/api/?name='.$meal->vendor_name }}" class="w-full h-full object-cover">
                                </div>
                                <span class="text-xs font-medium text-gray-500 group-hover/vendor:text-orange-500 transition-colors">{{ $meal->vendor_name }}</span>
                            </a>

                            <div class="flex flex-col gap-2">
                                <a href="{{ route('product.whatsapp.click', $meal->id) }}" 
                                   target="_blank"
                                   class="w-full py-3 md:py-3.5 bg-[#25D366] hover:bg-[#128C7E] text-white rounded-2xl font-bold flex items-center justify-center gap-2 transition-all duration-300 shadow-lg shadow-green-100 active:scale-95 group/btn">
                                    <i data-lucide="message-circle" class="w-5 h-5 group-hover/btn:scale-110 transition-transform"></i>
                                    <span class="text-sm md:text-base">Commander</span>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            {{-- ÉTAT VIDE --}}
            <div class="text-center py-12 md:py-20 bg-white rounded-3xl border border-dashed border-gray-200 max-w-2xl mx-auto px-4">
                <div class="bg-orange-50 w-16 h-16 md:w-20 md:h-20 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i data-lucide="search-x" class="w-8 h-8 md:w-10 md:h-10 text-orange-500"></i>
                </div>
                <h3 class="text-xl md:text-2xl font-bold text-gray-900 mb-2">Oups ! Aucun plat trouvé</h3>
                <p class="text-sm md:text-base text-gray-500 mb-8">
                    Nous n'avons trouvé aucun résultat pour cette recherche.
                </p>
                <div class="flex flex-col sm:flex-row gap-3 justify-center">
                    <a href="{{ route('search') }}" class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-gray-100 text-gray-700 font-semibold rounded-xl text-sm">
                        <i data-lucide="rotate-ccw" class="w-4 h-4"></i> Réinitialiser
                    </a>
                    <a href="{{ route('home') }}" class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-orange-500 text-white font-semibold rounded-xl text-sm shadow-lg shadow-orange-100">
                        <i data-lucide="home" class="w-4 h-4"></i> Accueil
                    </a>
                </div>
            </div>
        @endif
    </section>
</div>
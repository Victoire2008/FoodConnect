@extends('layouts.show') {{-- Correction de la petite faute de frappe 'layoutts' --}}

@section('content')
<div class="min-h-screen bg-[#fffcf9]">
    {{-- HEADER DU VENDEUR --}}
    <div class="bg-white border-b border-orange-50 relative overflow-hidden">
        {{-- Décoration subtile en arrière-plan --}}
        <div class="absolute top-0 right-0 w-64 h-64 bg-orange-50/50 rounded-full -mr-32 -mt-32 blur-3xl"></div>
        
        <div class="max-w-7xl mx-auto px-6 py-10 md:py-16 relative">
            <div class="flex flex-col md:flex-row items-center gap-8 md:gap-12">
                
                {{-- Photo de Profil avec Badge Statut --}}
                <div class="relative group">
                    <div class="w-32 h-32 md:w-44 md:h-44 rounded-[2.5rem] overflow-hidden shadow-2xl transition-transform duration-500 group-hover:scale-105 group-hover:rotate-0 rotate-3 border-4 border-white">
                        <img src="{{ $vendeur->photo ? asset('storage/' . $vendeur->photo) : asset('images/default-avatar.png') }}" 
                             class="w-full h-full object-cover" 
                             alt="{{ $vendeur->nom }}">
                    </div>
                    
                    {{-- Badge Statut Flottant --}}
                    <div class="absolute -bottom-2 -right-2 px-4 py-1.5 rounded-full border-4 border-white shadow-lg {{ $vendeur->is_open ? 'bg-green-500' : 'bg-red-500' }} flex items-center gap-2">
                        <span class="relative flex h-2 w-2">
                            @if($vendeur->is_open)
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-white opacity-75"></span>
                            @endif
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-white"></span>
                        </span>
                        <span class="text-[10px] font-black text-white uppercase tracking-wider">
                            {{ $vendeur->is_open ? 'Ouvert' : 'Fermé' }}
                        </span>
                    </div>
                </div>

                {{-- Infos Vendeur --}}
                <div class="flex-1 text-center md:text-left">
                    <div class="flex flex-col md:flex-row md:items-center gap-2 md:gap-4 mb-4">
                        <h1 class="text-3xl md:text-5xl font-black text-gray-900 tracking-tight">{{ $vendeur->nom }}</h1>
                    </div>
                    
                    <p class="text-gray-500 max-w-2xl text-base md:text-lg leading-relaxed mb-8 italic">
                        "{{ $vendeur->bio ?? "Bienvenue dans ma cuisine ! Je vous prépare des plats faits maison avec amour." }}"
                    </p>

                    <div class="flex flex-wrap justify-center md:justify-start gap-4 md:gap-8 text-sm text-gray-600 font-bold">
                        <div class="flex items-center gap-2.5 bg-gray-50 px-4 py-2 rounded-xl">
                            <i data-lucide="map-pin" class="w-5 h-5 text-orange-500"></i>
                            <span>{{ $vendeur->commune->name ?? 'Zone non définie' }}, {{ $vendeur->ville->name ?? '' }}</span>
                        </div>
                        <div class="flex items-center gap-2.5 bg-gray-50 px-4 py-2 rounded-xl">
                            <i data-lucide="utensils" class="w-5 h-5 text-orange-500"></i>
                            <span>{{ $plats->count() }} Spécialités au menu</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- GRILLE DES PLATS --}}
    <div class="max-w-7xl mx-auto px-6 py-12 md:py-20">
        <div class="flex items-center justify-between mb-12">
            <div>
                <h2 class="text-2xl md:text-3xl font-black text-gray-900">Le Menu du Jour</h2>
                <div class="h-1.5 w-12 bg-orange-500 rounded-full mt-2"></div>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 md:gap-10">
            @forelse($plats as $plat)
                <div class="group bg-white rounded-[2.8rem] p-4 shadow-sm border border-gray-100 hover:shadow-2xl hover:-translate-y-2 transition-all duration-300">
                    <div class="relative h-60 overflow-hidden rounded-[2.2rem] mb-6">
                        <img src="{{ asset('storage/' . $plat->image) }}" 
                             class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
                             alt="{{ $plat->name }}">
                        
                        <div class="absolute top-4 right-4 bg-white/95 backdrop-blur-md px-4 py-2 rounded-2xl font-black text-gray-900 shadow-sm border border-white/20">
                            {{ number_format($plat->prix, 0, ',', ' ') }} 
                            <span class="text-orange-500 text-[10px] ml-0.5">FCFA</span>
                        </div>

                        {{-- Overlay si épuisé --}}
                        @if(!$plat->is_available)
                            <div class="absolute inset-0 bg-gray-900/60 backdrop-blur-[2px] flex items-center justify-center">
                                <span class="bg-white text-gray-900 px-6 py-2 rounded-full font-black uppercase text-sm tracking-widest rotate-12">Épuisé</span>
                            </div>
                        @endif
                    </div>

                    <div class="px-2 pb-2">
                        <h3 class="text-xl font-extrabold text-gray-900 mb-6 line-clamp-1 group-hover:text-orange-500 transition-colors">
                            {{ $plat->name }}
                        </h3>
                        
                        <a href="{{ $plat->is_available ? route('product.whatsapp.click', $plat->id) : '#' }}"
                           @if($plat->is_available) target="_blank" @endif
                           class="w-full py-4 rounded-[1.5rem] font-black flex items-center justify-center gap-3 transition-all
                           {{ $plat->is_available 
                              ? 'bg-green-500 hover:bg-green-600 text-white shadow-lg shadow-green-100' 
                              : 'bg-gray-100 text-gray-400 cursor-not-allowed' }}">
                            <i data-lucide="message-circle" class="w-5 h-5"></i>
                            {{ $plat->is_available ? 'Commander' : 'Indisponible' }}
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-20 text-center">
                    <div class="inline-flex items-center justify-center w-20 h-20 bg-orange-50 text-orange-200 rounded-full mb-4">
                        <i data-lucide="utensils-crossed" class="w-10 h-10"></i>
                    </div>
                    <p class="text-gray-400 font-bold text-lg">Aucun plat n'est disponible pour le moment.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
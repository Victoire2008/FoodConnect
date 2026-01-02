@extends('layoutts.show') {{-- Utilise ton layout principal --}}

@section('content')
<div class="min-h-screen bg-[#fffcf9]">
    {{-- HEADER DU VENDEUR --}}
    <div class="bg-white border-b border-orange-100">
        <div class="max-w-7xl mx-auto px-6 py-12">
            <div class="flex flex-col md:flex-row items-center gap-8">
                {{-- Photo de Profil --}}
                <div class="relative">
                    <div class="w-32 h-32 md:w-40 md:h-40 rounded-[2.5rem] overflow-hidden shadow-2xl rotate-3">
                        <img src="{{ $vendeur->photo ? asset('storage/' . $vendeur->photo) : asset('images/default-avatar.png') }}" 
                             class="w-full h-full object-cover" 
                             alt="{{ $vendeur->nom }}">
                    </div>
                </div>

                {{-- Infos Vendeur --}}
                <div class="flex-1 text-center md:text-left">
                    <h1 class="text-4xl font-black text-gray-900 mb-4">{{ $vendeur->nom }}</h1>
                    
                    <p class="text-gray-600 max-w-2xl text-lg leading-relaxed mb-6">
                        {{ $vendeur->bio ?? "Bienvenue dans ma boutique ! Découvrez mes spécialités culinaires." }}
                    </p>

                    <div class="flex flex-wrap justify-center md:justify-start gap-6 text-sm text-gray-500 font-semibold">
                        <div class="flex items-center gap-2">
                            <i data-lucide="map-pin" class="w-5 h-5 text-orange-500"></i>
                            <span>{{ $vendeur->ville->name ?? 'Côte d\'Ivoire' }}, {{ $vendeur->commune->name ?? '' }}</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <i data-lucide="utensils" class="w-5 h-5 text-orange-500"></i>
                            <span>{{ $plats->count() }} Plats au menu</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- GRILLE DES PLATS --}}
    <div class="max-w-7xl mx-auto px-6 py-16">
        <h2 class="text-2xl font-bold text-gray-900 mb-10">Au menu chez {{ $vendeur->name }}</h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            @foreach($plats as $plat)
                <div class="bg-white rounded-[2.5rem] p-4 shadow-sm border border-gray-50 hover:shadow-xl transition-shadow duration-300">
                    <div class="relative h-56 overflow-hidden rounded-[2rem] mb-5">
                        <img src="{{ asset('storage/' . $plat->image) }}" class="w-full h-full object-cover">
                        
                        <div class="absolute top-4 right-4 bg-white/95 backdrop-blur px-4 py-2 rounded-2xl font-black text-gray-900 shadow-sm">
                            {{ number_format($plat->prix ?? $plat->price, 0, ',', ' ') }} 
                            <span class="text-orange-500 text-[10px] ml-1">FCFA</span>
                        </div>
                    </div>

                    <div class="px-2">
                        <h3 class="text-xl font-bold text-gray-900 mb-4 truncate">{{ $plat->name }}</h3>
                        
                        {{-- On utilise notre route de tracking pour compter les clics --}}
                        <a href="{{ route('product.whatsapp.click', $plat->id) }}"
                           target="_blank"
                           class="w-full py-4 bg-green-500 hover:bg-green-600 text-white rounded-2xl font-bold flex items-center justify-center gap-3 transition-colors shadow-lg shadow-green-100">
                            <i data-lucide="message-circle" class="w-5 h-5"></i>
                            Commander
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
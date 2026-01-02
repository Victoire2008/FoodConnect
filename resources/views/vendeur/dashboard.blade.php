<x-app-layout>
    <div class="min-h-screen bg-[#fffcf9] p-6">
        <div class="max-w-7xl mx-auto">
            
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
                <div>
                    <h1 class="text-3xl font-black text-gray-900">Mon Espace Cuisine</h1>
                    <p class="text-gray-500">Gérez vos plats et suivez vos statistiques en temps réel.</p>
                </div>
                
              {{-- Indicateur de statut pour le Vendeur (Lecture seule) --}}
<div class="px-4 py-2 rounded-2xl border-2 {{ auth()->user()->is_open ? 'border-green-100 bg-green-50' : 'border-red-100 bg-red-50' }} flex items-center gap-3">
    <span class="relative flex h-3 w-3">
        <span class="{{ auth()->user()->is_open ? 'animate-ping bg-green-400' : 'bg-red-400' }} absolute inline-flex h-full w-full rounded-full opacity-75"></span>
        <span class="relative inline-flex rounded-full h-3 w-3 {{ auth()->user()->is_open ? 'bg-green-500' : 'bg-red-500' }}"></span>
    </span>
    <div class="flex flex-col items-start">
        <span class="text-[10px] font-black {{ auth()->user()->is_open ? 'text-green-400' : 'text-red-400' }} uppercase leading-none">Statut Boutique</span>
        <span class="text-sm font-bold {{ auth()->user()->is_open ? 'text-green-700' : 'text-red-700' }}">
            {{ auth()->user()->is_open ? 'OUVERT' : 'FERMÉE' }}
        </span>
    </div>
</div>

                    <a href="{{ route('vendeur.products.create') }}" class="bg-orange-500 hover:bg-orange-600 text-white px-6 py-3 rounded-2xl font-bold transition shadow-lg shadow-orange-200 flex items-center gap-2">
                        <i data-lucide="plus-circle" class="w-5 h-5"></i> Ajouter un plat
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
                <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-gray-100">
                    <div class="w-12 h-12 bg-orange-100 text-orange-600 rounded-2xl flex items-center justify-center mb-4">
                        <i data-lucide="utensils"></i>
                    </div>
                    <p class="text-gray-400 text-xs font-bold uppercase tracking-wider">Plats Actifs</p>
                    <p class="text-3xl font-black text-gray-900 mt-1">{{ $products->where('is_active', 1)->count() }}</p>
                </div>

                <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-gray-100">
                    <div class="w-12 h-12 bg-green-100 text-green-600 rounded-2xl flex items-center justify-center mb-4">
                        <i data-lucide="message-circle"></i>
                    </div>
                    <p class="text-gray-400 text-xs font-bold uppercase tracking-wider">Clics WhatsApp</p>
                    <p class="text-3xl font-black text-gray-900 mt-1">{{ $products->sum('clicks_count') ?? 0 }}</p>
                </div>

                <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-gray-100">
                    <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-2xl flex items-center justify-center mb-4">
                        <i data-lucide="trending-up"></i>
                    </div>
                    <p class="text-gray-400 text-xs font-bold uppercase tracking-wider">Top Plat</p>
                    <p class="text-lg font-black text-gray-900 mt-1 truncate">{{ $products->sortByDesc('clicks_count')->first()->name ?? '---' }}</p>
                </div>

                <div class="bg-gray-900 p-6 rounded-[2rem] shadow-lg text-white">
                    <div class="w-12 h-12 bg-white/10 text-orange-400 rounded-2xl flex items-center justify-center mb-4">
                        <i data-lucide="map-pin"></i>
                    </div>
                    <p class="text-gray-400 text-xs font-bold uppercase tracking-wider">Zone</p>
                    <p class="text-sm font-bold mt-1">
                        {{ auth()->user()->ville->name ?? '---' }} <br> 
                        <span class="text-orange-400 text-xs">{{ auth()->user()->commune->name ?? '---' }}</span>
                    </p>
                </div>
            </div>

            <div class="bg-white rounded-[2.5rem] shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-50 bg-gray-50/50">
                    <h2 class="font-bold text-gray-800">Gestion du menu</h2>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="text-gray-400 text-[11px] uppercase tracking-widest font-black">
                                <th class="p-6">Plat</th>
                                <th class="p-6 text-center">Statut (Visibilité)</th>
                                <th class="p-6">Performances</th>
                                <th class="p-6 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                           @forelse($products as $product)
<tr class="hover:bg-orange-50/30 transition group {{ !$product->is_visible ? 'bg-gray-50/50' : '' }}">
    <td class="p-6">
        <div class="flex items-center gap-4">
            <div class="relative">
                <div class="w-16 h-16 rounded-2xl overflow-hidden shadow-sm">
                    <img src="{{ asset('storage/' . $product->image) }}" class="w-full h-full object-cover {{ !$product->is_visible ? 'grayscale' : '' }}">
                </div>
                @if(!$product->is_available)
                    <span class="absolute -top-2 -right-2 bg-red-500 text-white text-[8px] px-2 py-1 rounded-lg font-black uppercase shadow-lg">Épuisé</span>
                @endif
            </div>
            <div>
                <p class="font-bold text-gray-900">{{ $product->name }}</p>
                <p class="text-orange-500 font-black text-sm">{{ number_format($product->prix) }} <small>FCFA</small></p>
            </div>
        </div>
    </td>
    
    <td class="p-6 text-center">
        {{-- SWITCH DE VISIBILITÉ RAPIDE --}}
        <form action="{{ route('vendeur.products.toggle', $product) }}" method="POST">
            @csrf @method('PATCH')
            <button type="submit" class="group flex items-center justify-center mx-auto">
                <div class="flex items-center gap-2 px-3 py-1.5 rounded-full transition-all {{ $product->is_visible ? 'bg-green-100 text-green-600' : 'bg-gray-200 text-gray-500' }}">
                    <div class="w-2 h-2 rounded-full {{ $product->is_visible ? 'bg-green-500 animate-pulse' : 'bg-gray-400' }}"></div>
                    <span class="text-[10px] font-black uppercase">{{ $product->is_visible ? 'En ligne' : 'Masqué' }}</span>
                </div>
            </button>
        </form>
    </td>

    <td class="p-6">
        <div class="flex flex-col gap-1">
            <div class="flex items-center gap-2 text-gray-500 text-sm font-bold">
                <i data-lucide="eye" class="w-4 h-4 text-blue-500"></i>
                {{ $product->views_count ?? 0 }} <span class="text-[10px] text-gray-400 font-normal italic underline">vues</span>
            </div>
            <div class="flex items-center gap-2 text-gray-500 text-sm font-bold">
                <i data-lucide="message-circle" class="w-4 h-4 text-green-500"></i>
                {{ $product->clicks_count ?? 0 }} <span class="text-[10px] text-gray-400 font-normal italic underline">clics</span>
            </div>
        </div>
    </td>

    <td class="p-6">
        <div class="flex gap-2 justify-end">
            <a href="{{ route('vendeur.products.edit', $product) }}" class="p-3 bg-white border border-gray-100 text-blue-600 rounded-xl hover:bg-blue-600 hover:text-white transition-all shadow-sm">
                <i data-lucide="edit-3" class="w-4 h-4"></i>
            </a>
            
            <form method="POST" action="{{ route('vendeur.products.destroy', $product) }}" onsubmit="return confirm('Supprimer ce délice ?')">
                @csrf @method('DELETE')
                <button class="p-3 bg-white border border-gray-100 text-red-600 rounded-xl hover:bg-red-600 hover:text-white transition-all shadow-sm">
                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                </button>
            </form>
        </div>
    </td>
</tr>
@empty
@endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    

</x-app-layout>
<x-app-layout>
    <div class="min-h-screen bg-[#fffcf9] p-4 md:p-6">
        <div class="max-w-7xl mx-auto">
            
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
                <div>
                    <h1 class="text-2xl md:text-3xl font-black text-gray-900">Mon Espace Cuisine</h1>
                    <p class="text-gray-500 text-sm md:text-base">Gérez vos plats et suivez vos statistiques en temps réel.</p>
                </div>
                
                <div class="flex items-center gap-3 self-end sm:self-auto">
                    {{-- Indicateur de statut boutique --}}
                    <div class="px-3 py-2 rounded-2xl border-2 {{ auth()->user()->is_open ? 'border-green-100 bg-green-50' : 'border-red-100 bg-red-50' }} flex items-center gap-2">
                        <span class="relative flex h-3 w-3">
                            <span class="{{ auth()->user()->is_open ? 'animate-ping bg-green-400' : 'bg-red-400' }} absolute inline-flex h-full w-full rounded-full opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-3 w-3 {{ auth()->user()->is_open ? 'bg-green-500' : 'bg-red-500' }}"></span>
                        </span>
                        <div class="flex flex-col">
                            <span class="text-[9px] font-black {{ auth()->user()->is_open ? 'text-green-400' : 'text-red-400' }} uppercase leading-none">Statut</span>
                            <span class="text-xs font-bold {{ auth()->user()->is_open ? 'text-green-700' : 'text-red-700' }}">
                                {{ auth()->user()->is_open ? 'OUVERT' : 'FERMÉ' }}
                            </span>
                        </div>
                    </div>

                    <a href="{{ route('vendeur.products.create') }}" class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2.5 rounded-2xl font-bold transition shadow-lg shadow-orange-100 flex items-center gap-2 text-sm whitespace-nowrap">
                        <i data-lucide="plus-circle" class="w-4 h-4"></i> <span>Ajouter un plat</span>
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6 mb-10">
                <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-gray-100">
                    <div class="w-12 h-12 bg-orange-100 text-orange-600 rounded-2xl flex items-center justify-center mb-4">
                        <i data-lucide="utensils" class="w-6 h-6"></i>
                    </div>
                    <p class="text-gray-400 text-[10px] font-black uppercase tracking-wider">Plats Actifs</p>
                    <p class="text-3xl font-black text-gray-900 mt-1">{{ $products->where('is_active', 1)->count() }}</p>
                </div>

                <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-gray-100">
                    <div class="w-12 h-12 bg-green-100 text-green-600 rounded-2xl flex items-center justify-center mb-4">
                        <i data-lucide="message-circle" class="w-6 h-6"></i>
                    </div>
                    <p class="text-gray-400 text-[10px] font-black uppercase tracking-wider">Clics WhatsApp</p>
                    <p class="text-3xl font-black text-gray-900 mt-1">{{ $products->sum('clicks_count') ?? 0 }}</p>
                </div>

                <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-gray-100">
                    <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-2xl flex items-center justify-center mb-4">
                        <i data-lucide="trending-up" class="w-6 h-6"></i>
                    </div>
                    <p class="text-gray-400 text-[10px] font-black uppercase tracking-wider">Top Plat</p>
                    <p class="text-lg font-black text-gray-900 mt-1 truncate">{{ $products->sortByDesc('clicks_count')->first()->name ?? '---' }}</p>
                </div>

                <div class="bg-gray-900 p-6 rounded-[2rem] shadow-lg text-white">
                    <div class="w-12 h-12 bg-white/10 text-orange-400 rounded-2xl flex items-center justify-center mb-4">
                        <i data-lucide="map-pin" class="w-6 h-6"></i>
                    </div>
                    <p class="text-gray-400 text-[10px] font-black uppercase tracking-wider">Ma Zone</p>
                    <p class="text-sm font-bold mt-1 leading-tight">
                        {{ auth()->user()->ville->name ?? '---' }} <br> 
                        <span class="text-orange-400 text-xs font-medium">{{ auth()->user()->commune->name ?? '---' }}</span>
                    </p>
                </div>
            </div>

            <div class="bg-white rounded-[2.5rem] shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-50 bg-gray-50/50 flex justify-between items-center">
                    <h2 class="font-black text-gray-800 uppercase text-sm tracking-wide">Gestion du menu</h2>
                    <span class="bg-white px-3 py-1 rounded-full text-[10px] font-bold text-gray-400 border border-gray-100">{{ $products->count() }} Plats au total</span>
                </div>

                <div class="hidden md:block overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="text-gray-400 text-[11px] uppercase tracking-widest font-black border-b border-gray-50">
                                <th class="p-6">Plat</th>
                                <th class="p-6 text-center">Visibilité</th>
                                <th class="p-6">Performances</th>
                                <th class="p-6 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse($products as $product)
                                <tr class="hover:bg-orange-50/30 transition group {{ !$product->is_visible ? 'bg-gray-50/50 opacity-75' : '' }}">
                                    <td class="p-6">
                                        <div class="flex items-center gap-4">
                                            <div class="relative w-16 h-16 shrink-0 shadow-sm rounded-2xl overflow-hidden border border-gray-100">
                                                <img src="{{ asset('storage/' . $product->image) }}" class="w-full h-full object-cover {{ !$product->is_visible ? 'grayscale' : '' }}">
                                                @if(!$product->is_available)
                                                    <span class="absolute inset-0 bg-black/40 flex items-center justify-center text-[8px] text-white font-black uppercase">Épuisé</span>
                                                @endif
                                            </div>
                                            <div>
                                                <p class="font-bold text-gray-900">{{ $product->name }}</p>
                                                <p class="text-orange-500 font-black text-sm">{{ number_format($product->prix, 0, ',', ' ') }} <small>FCFA</small></p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="p-6 text-center">
                                        <form action="{{ route('vendeur.products.toggle', $product) }}" method="POST">
                                            @csrf @method('PATCH')
                                            <button type="submit" class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full {{ $product->is_visible ? 'bg-green-100 text-green-600' : 'bg-gray-200 text-gray-500' }} transition-all hover:scale-105">
                                                <div class="w-1.5 h-1.5 rounded-full {{ $product->is_visible ? 'bg-green-500 animate-pulse' : 'bg-gray-400' }}"></div>
                                                <span class="text-[10px] font-black uppercase">{{ $product->is_visible ? 'Public' : 'Masqué' }}</span>
                                            </button>
                                        </form>
                                    </td>
                                    <td class="p-6">
                                        <div class="flex items-center gap-4 text-xs font-bold text-gray-500">
                                            <span class="flex items-center gap-1.5"><i data-lucide="eye" class="w-3.5 h-3.5 text-blue-400"></i> {{ $product->views_count }}</span>
                                            <span class="flex items-center gap-1.5"><i data-lucide="message-circle" class="w-3.5 h-3.5 text-green-400"></i> {{ $product->clicks_count }}</span>
                                        </div>
                                    </td>
                                    <td class="p-6">
                                        <div class="flex gap-2 justify-end">
                                            <a href="{{ route('vendeur.products.edit', $product) }}" class="p-2.5 bg-white border border-gray-100 text-blue-600 rounded-xl hover:bg-blue-600 hover:text-white transition shadow-sm">
                                                <i data-lucide="edit-3" class="w-4 h-4"></i>
                                            </a>
                                            <form method="POST" action="{{ route('vendeur.products.destroy', $product) }}" onsubmit="return confirm('Supprimer ce délice ?')">
                                                @csrf @method('DELETE')
                                                <button class="p-2.5 bg-white border border-gray-100 text-red-600 rounded-xl hover:bg-red-600 hover:text-white transition shadow-sm">
                                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="4" class="p-12 text-center text-gray-400">Aucun plat ajouté.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="md:hidden divide-y divide-gray-50">
                    @forelse($products as $product)
                        <div class="p-5 flex flex-col gap-4 {{ !$product->is_visible ? 'bg-gray-50/50' : '' }}">
                            <div class="flex items-start gap-4">
                                <div class="w-20 h-20 shrink-0 rounded-2xl overflow-hidden border border-gray-100 relative">
                                    <img src="{{ asset('storage/' . $product->image) }}" class="w-full h-full object-cover">
                                    @if(!$product->is_available)
                                        <span class="absolute inset-0 bg-red-500/20 backdrop-blur-[1px]"></span>
                                    @endif
                                </div>
                                <div class="flex-1">
                                    <div class="flex justify-between items-start">
                                        <h3 class="font-bold text-gray-900 leading-tight">{{ $product->name }}</h3>
                                        <form action="{{ route('vendeur.products.toggle', $product) }}" method="POST">
                                            @csrf @method('PATCH')
                                            <button type="submit" class="w-8 h-8 rounded-full flex items-center justify-center {{ $product->is_visible ? 'bg-green-100 text-green-600' : 'bg-gray-200 text-gray-500' }}">
                                                <i data-lucide="{{ $product->is_visible ? 'eye' : 'eye-off' }}" class="w-4 h-4"></i>
                                            </button>
                                        </form>
                                    </div>
                                    <p class="text-orange-500 font-black mt-1">{{ number_format($product->prix) }} FCFA</p>
                                    <div class="flex items-center gap-3 mt-2 text-[10px] font-bold text-gray-400 uppercase">
                                        <span class="flex items-center gap-1"><i data-lucide="eye" class="w-3 h-3"></i> {{ $product->views_count }}</span>
                                        <span class="flex items-center gap-1"><i data-lucide="message-circle" class="w-3 h-3 text-green-400"></i> {{ $product->clicks_count }} clics</span>
                                    </div>
                                </div>
                            </div>
                            <div class="flex gap-2">
                                <a href="{{ route('vendeur.products.edit', $product) }}" class="flex-1 bg-gray-50 text-blue-600 py-2.5 rounded-xl font-bold text-xs flex items-center justify-center gap-2 border border-blue-50">
                                    <i data-lucide="edit-3" class="w-3.5 h-3.5"></i> Modifier
                                </a>
                                <form method="POST" action="{{ route('vendeur.products.destroy', $product) }}" class="flex-1">
                                    @csrf @method('DELETE')
                                    <button class="w-full bg-red-50 text-red-600 py-2.5 rounded-xl font-bold text-xs flex items-center justify-center gap-2 border border-red-100">
                                        <i data-lucide="trash-2" class="w-3.5 h-3.5"></i> Supprimer
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="p-10 text-center text-gray-400 text-sm">Aucun plat disponible.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
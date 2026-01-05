<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>FoodConnect.ci - Découvrez les saveurs culinaires</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lobster&family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="{{ asset('images/Logo FoodConnect.ci en dégradé chaleureux.png') }}" type="image/x-icon">
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        @keyframes float { 0%, 100% { transform: translateY(0px) rotate(0deg); } 50% { transform: translateY(-15px) rotate(5deg); } }
        @keyframes fadeInUp { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }
        .animate-float { animation: float 3s ease-in-out infinite; }
        .animate-fade-in-up { animation: fadeInUp 0.8s ease-out; }
        .font-lobster { font-family: 'Lobster', cursive; }
        .font-poppins { font-family: 'Poppins', sans-serif; }
        .hero-overlay { background: linear-gradient(135deg, rgba(0,0,0,0.8) 0%, rgba(0,0,0,0.4) 100%); }
    </style>
</head>

<body class="bg-white font-poppins overflow-x-hidden">

    <header class="bg-white border-b border-gray-100 sticky top-0 z-50 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 md:px-6 py-4 flex justify-between items-center">
            {{-- LOGO --}}
            <a href="{{ route('home') }}" class="flex items-center gap-2 md:gap-3 group">
                <div class="p-1.5 md:p-2 bg-orange-500 rounded-xl group-hover:rotate-12 transition-transform">
                    <i data-lucide="utensils-crossed" class="w-5 h-5 md:w-6 md:h-6 text-white"></i>
                </div>
                <div class="text-xl md:text-2xl font-bold text-gray-900 font-lobster leading-none">
                    FoodConnect<span class="text-orange-500">.ci</span>
                </div>
            </a>

            {{-- DESKTOP NAV --}}
            <nav class="hidden lg:flex items-center space-x-6 text-sm font-medium">
                @auth
                    <a href="{{ auth()->user()->role === 'admin' ? route('admin.dashboard') : (auth()->user()->role === 'vendeur' ? route('vendeur.dashboard') : route('dashboard')) }}" 
                       class="text-gray-700 hover:text-orange-500 flex items-center gap-2 transition">
                        <i data-lucide="layout-dashboard" class="w-4 h-4"></i> Tableau de bord
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-gray-700 hover:text-red-500 flex items-center gap-2 transition">
                            <i data-lucide="log-out" class="w-4 h-4"></i> Déconnexion
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="text-gray-700 hover:text-orange-500 transition">Connexion</a>
                    <a href="{{ route('register') }}" class="bg-orange-500 text-white px-5 py-2.5 rounded-xl hover:bg-orange-600 transition shadow-lg shadow-orange-100 flex items-center gap-2">
                        <i data-lucide="user-plus" class="w-4 h-4"></i> Devenir vendeur
                    </a>
                @endauth
            </nav>

            {{-- MOBILE BURGER BUTTON --}}
            <button class="lg:hidden p-2 text-gray-600" id="mobile-menu-btn">
                <i data-lucide="menu" class="w-7 h-7"></i>
            </button>
        </div>

        {{-- MOBILE MENU (JS toggle) --}}
        <div id="mobile-menu" class="hidden lg:hidden bg-white border-t border-gray-100 px-4 py-6 space-y-4 shadow-xl">
             @auth
                <a href="{{ route('dashboard') }}" class="block text-gray-700 font-medium px-4 py-2 hover:bg-orange-50 rounded-lg">Mon Tableau de bord</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left text-red-500 font-medium px-4 py-2">Déconnexion</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="block text-gray-700 font-medium px-4 py-2">Connexion</a>
                <a href="{{ route('register') }}" class="block bg-orange-500 text-white text-center font-bold px-4 py-3 rounded-xl">Devenir vendeur</a>
            @endauth
        </div>
    </header>

    <section class="relative w-full min-h-[500px] md:h-[650px] overflow-hidden bg-gray-900 flex items-center">
        @include('components.hero-slider')
        <div class="absolute inset-0 hero-overlay z-[2]"></div>

        <div class="relative max-w-7xl mx-auto px-6 md:px-16 z-[3] w-full animate-fade-in-up py-20">
            <div class="inline-flex items-center gap-2 bg-white/10 backdrop-blur-md text-white border border-white/20 px-4 py-2 rounded-full text-xs md:text-sm font-medium mb-6">
                <i data-lucide="sparkles" class="w-4 h-4 text-orange-400"></i>
                La cuisine ivoirienne à portée de main
            </div>

            <h1 class="text-4xl md:text-7xl font-bold mb-6 text-white leading-[1.1]">
                Savourez les<br/>
                <span class="text-orange-400">meilleurs plats</span><br class="hidden md:block"/>
                faits maison
            </h1>

            <p class="text-lg md:text-2xl font-light max-w-2xl mb-10 text-gray-200 leading-relaxed">
                Des repas authentiques cuisinés par les passionnés de votre quartier.
            </p>

            <div class="flex flex-col sm:flex-row gap-4">
                <a href="{{ route('search') }}" class="bg-orange-500 text-white px-8 py-4 rounded-xl hover:bg-orange-600 transition-all text-center font-bold shadow-lg flex items-center justify-center gap-2">
                    <i data-lucide="search" class="w-5 h-5"></i> Explorer les plats
                </a>
                <a href="{{ route('register') }}" class="bg-white/10 backdrop-blur-md text-white border border-white/30 px-8 py-4 rounded-xl hover:bg-white/20 transition-all text-center font-bold flex items-center justify-center gap-2">
                    <i data-lucide="chef-hat" class="w-5 h-5"></i> Devenir vendeur
                </a>
            </div>
        </div>
    </section>

    <div class="w-full flex justify-center -mt-10 md:-mt-16 px-4 relative z-10">
        <div class="bg-white shadow-2xl rounded-[2rem] p-6 md:p-8 w-full max-w-5xl border border-gray-100">
            <form action="{{ route('search') }}" method="GET" class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                    {{-- Input Texte --}}
                    <div class="space-y-2">
                        <label class="text-xs font-bold text-gray-500 uppercase ml-1 tracking-wider flex items-center gap-2">
                            <i data-lucide="utensils" class="w-3.5 h-3.5 text-orange-500"></i> Que mangeons-nous ?
                        </label>
                        <input type="text" name="q" placeholder="Ex: Garba, Foutou..." class="w-full px-5 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-2 focus:ring-orange-500 outline-none transition-all">
                    </div>

                    {{-- Ville --}}
                    <div class="space-y-2">
                        <label class="text-xs font-bold text-gray-500 uppercase ml-1 tracking-wider flex items-center gap-2">
                            <i data-lucide="map-pin" class="w-3.5 h-3.5 text-orange-500"></i> Localisation
                        </label>
                        <select name="ville_id" id="ville-select" class="w-full px-5 py-4 bg-gray-50 border border-gray-100 rounded-2xl outline-none focus:ring-2 focus:ring-orange-500">
                            <option value="">Toute la CI</option>
                            @foreach($villes as $ville)
                                <option value="{{ $ville->id }}">{{ $ville->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Commune --}}
                    <div class="space-y-2">
                        <label class="text-xs font-bold text-gray-500 uppercase ml-1 tracking-wider flex items-center gap-2">
                            <i data-lucide="map" class="w-3.5 h-3.5 text-orange-500"></i> Commune
                        </label>
                        <select name="commune_id" id="commune-select" disabled class="w-full px-5 py-4 bg-gray-50 border border-gray-100 rounded-2xl outline-none opacity-50 focus:ring-2 focus:ring-orange-500">
                            <option value="">Toutes les communes</option>
                        </select>
                    </div>
                </div>

                <button type="submit" class="w-full bg-orange-500 hover:bg-orange-600 text-white py-4 md:py-5 rounded-2xl font-black text-lg shadow-lg shadow-orange-100 transition-all flex items-center justify-center gap-3">
                    <i data-lucide="search" class="w-6 h-6"></i> Lancer la recherche
                </button>
            </form>
        </div>
    </div>

    <main class="max-w-7xl mx-auto px-4 md:px-6 space-y-24 py-20">
        
        {{-- Categories --}}
        <section>
            <div class="mb-10 text-center md:text-left">
                <h2 class="text-3xl font-black text-gray-900">Catégories</h2>
                <div class="h-1 w-20 bg-orange-500 mt-2 mx-auto md:ml-0 rounded-full"></div>
            </div>
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">
                @foreach($categories as $category)
                    {{-- On utilise le design de bouton que tu avais --}}
                    <a href="{{ route('search', ['category_id' => $category->id]) }}" class="bg-white border border-gray-100 p-6 rounded-[2rem] text-center group hover:shadow-xl transition-all">
                        <div class="w-12 h-12 md:w-16 md:h-16 bg-orange-50 rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform">
                             <i data-lucide="utensils" class="text-orange-500"></i>
                        </div>
                        <span class="font-bold text-gray-800 text-sm block truncate">{{ $category->name }}</span>
                    </a>
                @endforeach
            </div>
        </section>

        {{-- Vendeurs --}}
        <section>
             <h2 class="text-3xl font-black text-gray-900 mb-8">Meilleurs Cuisiniers</h2>
             <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($vendors->take(4) as $vendor)
                    <a href="{{ route('vendeur.store.show', $vendor->id) }}" class="bg-white rounded-3xl border border-gray-100 overflow-hidden shadow-sm hover:shadow-xl transition-all group">
                        <div class="h-24 bg-orange-500"></div>
                        <div class="px-6 pb-8 text-center -mt-10">
                            <div class="w-20 h-20 rounded-full border-4 border-white mx-auto overflow-hidden bg-gray-100 shadow-md">
                                <img src="{{ $vendor->photo ? asset('storage/' . $vendor->photo) : 'https://ui-avatars.com/api/?name='.$vendor->nom }}" class="w-full h-full object-cover">
                            </div>
                            <h3 class="font-bold mt-4 text-gray-900">{{ $vendor->nom }}</h3>
                            <p class="text-xs text-gray-400 mt-1 line-clamp-1 px-4">{{ $vendor->bio ?? 'Passionné de cuisine' }}</p>
                        </div>
                    </a>
                @endforeach
             </div>
        </section>

    </main>

    {{-- Script pour le menu mobile et la logique existante --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            lucide.createIcons();

            // Menu Mobile Toggle
            const btn = document.getElementById('mobile-menu-btn');
            const menu = document.getElementById('mobile-menu');
            btn.addEventListener('click', () => menu.classList.toggle('hidden'));

            // Ton code de communes existant
            const villeSelect = document.getElementById('ville-select');
            const communeSelect = document.getElementById('commune-select');
            const communesData = @json($communes ?? []);

            villeSelect.addEventListener('change', function() {
                const villeId = this.value;
                communeSelect.innerHTML = '<option value="">Toutes les communes</option>';
                if (villeId) {
                    communeSelect.disabled = false;
                    communeSelect.classList.remove('opacity-50');
                    const filtrées = communesData.filter(c => c.ville_id == villeId);
                    filtrées.forEach(c => {
                        const opt = document.createElement('option');
                        opt.value = c.id;
                        opt.textContent = c.name;
                        communeSelect.appendChild(opt);
                    });
                } else {
                    communeSelect.disabled = true;
                    communeSelect.classList.add('opacity-50');
                }
            });
        });
    </script>
</body>
</html>
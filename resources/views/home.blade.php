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
        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-15px) rotate(5deg); }
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes shimmer {
            0% { background-position: -1000px 0; }
            100% { background-position: 1000px 0; }
        }

        .animate-float {
            animation: float 3s ease-in-out infinite;
        }

        .animate-fade-in-up {
            animation: fadeInUp 0.8s ease-out;
        }

        .font-lobster {
            font-family: 'Lobster', cursive;
        }

        .font-poppins {
            font-family: 'Poppins', sans-serif;
        }

        .loading-skeleton {
            background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
            background-size: 1000px 100%;
            animation: shimmer 2s infinite;
        }

        .hero-overlay {
            background: linear-gradient(135deg, rgba(0,0,0,0.7) 0%, rgba(0,0,0,0.4) 100%);
        }

        .food-bg {
            background-color: #fffcf9;
        }
    </style>
</head>

<body class="bg-white font-poppins flex-col min-h-screen">

    <!-- HEADER -->
    <header class="bg-white border-b border-gray-100 p-5 shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto flex flex-wrap justify-between items-center">
            <div class="flex items-center gap-3 group cursor-pointer">
                <div class="p-2 bg-orange-500 rounded-xl group-hover:scale-110 transition-transform">
                    <i data-lucide="utensils-crossed" class="w-6 h-6 text-white"></i>
                </div>
                <div class="text-2xl font-bold text-gray-900 font-lobster">
                    FoodConnect<span class="text-orange-500">.ci</span>
                </div>
            </div>

            <nav class="space-x-6 text-base flex flex-wrap items-center">
                @auth
                    <a href="@if (auth()->user()->role === 'admin')
                        {{ route('admin.dashboard') }}
                        @elseif (auth()->user()->role === 'vendeur')
                        {{ route('vendeur.dashboard') }}
                        @else
                        {{ route('dashboard') }}
                        @endif" class="text-gray-700 hover:text-orange-500 transition font-medium group flex items-center gap-2">
                        <i data-lucide="layout-dashboard" class="w-5 h-5"></i>
                        Tableau de bord
                    </a>
   
                    <form method="POST" action="{{ route('logout') }}" id="logout-form">
                        @csrf
                        <button type="submit"
                            class="text-gray-700 hover:text-red-500 transition font-medium group flex items-center gap-2 bg-transparent border-0 p-0 cursor-pointer">
                            <i data-lucide="log-out" class="w-5 h-5"></i>
                            Déconnexion
                        </button>
                    </form>

                @else
                    <a href="{{ route('login') }}" 
                       class="text-gray-700 hover:text-orange-500 transition font-medium group flex items-center gap-2">
                        <i data-lucide="log-in" class="w-5 h-5"></i>
                        Connexion
                    </a>

                    <a href="{{ route('register') }}" 
                       class="bg-orange-500 text-white px-6 py-2.5 rounded-lg hover:bg-orange-600 transition font-medium flex items-center gap-2 shadow-sm">
                        <i data-lucide="user-plus" class="w-5 h-5"></i>
                        Devenir vendeur
                    </a>
                @endauth
            </nav>
        </div>
    </header>

    <!-- HERO SECTION -->
    <section class="relative w-full h-[600px] mt-0 overflow-hidden bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900">
        @include('components.hero-slider')

        <div class="absolute inset-0 hero-overlay z-[2]"></div>

        <div class="absolute inset-0 flex flex-col justify-center items-start text-left text-white px-6 md:px-16 z-[3] max-w-7xl mx-auto animate-fade-in-up">
            <div class="inline-flex items-center gap-2 bg-white/10 backdrop-blur-md text-white border border-white/20 px-4 py-2 rounded-full text-sm font-medium mb-6">
              
                Plateforme de cuisine
            </div>

            <h1 class="text-4xl sm:text-5xl md:text-7xl font-bold mb-6 leading-tight">
                Savourez les<br/>
                <span class="text-orange-400">meilleurs plats</span><br/>
                de qualité
            </h1>

            <p class="text-lg sm:text-xl md:text-2xl font-light max-w-2xl mb-10 text-gray-200 leading-relaxed">
                Découvrez des repas faits maison par les meilleurs cuisiniers.
            </p>

            <div class="flex gap-4 flex-wrap">
                <a href="{{ route('search') }}" class="bg-orange-500 text-white px-6 sm:px-8 py-3 sm:py-4 rounded-lg hover:bg-orange-600 transition-all duration-300 text-base sm:text-lg font-semibold shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 flex items-center gap-2">
                    <i data-lucide="search" class="w-5 h-5"></i>
                    Explorer les plats
                </a>
                <a href="{{ route('register') }}" class="bg-white text-gray-900 px-6 sm:px-8 py-3 sm:py-4 rounded-lg hover:bg-gray-100 transition-all duration-300 text-base sm:text-lg font-semibold shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 flex items-center gap-2">
                    <i data-lucide="chef-hat" class="w-5 h-5"></i>
                    Devenir vendeur
                </a>
            </div>
        </div>

        <div class="absolute top-24 right-24 hidden lg:block animate-float z-[4]">
            <div class="p-4 bg-white/5 backdrop-blur-sm rounded-2xl border border-white/10">
                <i data-lucide="pizza" class="w-12 h-12 text-white/40"></i>
            </div>
        </div>
        <div class="absolute bottom-40 right-48 hidden lg:block animate-float z-[4]" style="animation-delay: 1s;">
            <div class="p-4 bg-white/5 backdrop-blur-sm rounded-2xl border border-white/10">
                <i data-lucide="salad" class="w-10 h-10 text-white/40"></i>
            </div>
        </div>
    </section>
    

    <!-- FORMULAIRE DE RECHERCHE -->
    <div class="w-full flex justify-center -mt-8 px-4 relative z-10">
        <div class="bg-white shadow-xl rounded-2xl p-6 w-full max-w-5xl border border-gray-100">
            <div class="flex items-center space-x-3 mb-5">
                <div class="bg-orange-50 text-orange-500 p-3 rounded-xl">
                    <i data-lucide="search" class="w-6 h-6"></i>
                </div>
                <div class="flex-1">
                    <p class="text-gray-500 text-sm font-medium">Rechercher des plats</p>
                    <p class="font-semibold text-gray-900">Trouvez les meilleurs plats disponibles</p>
                </div>
            </div>

            <form action="{{ route('search') }}" method="GET" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i data-lucide="utensils" class="w-4 h-4 inline mr-1"></i>
                            Plat ou vendeur
                        </label>
                        <input type="text"
                               name="q"
                               value="{{ request('q') }}"
                               class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent text-gray-900 placeholder-gray-400"
                               placeholder="Ex: Attiéké poisson...">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i data-lucide="map-pin" class="w-4 h-4 inline mr-1"></i>
                            Ville
                        </label>
                        <select name="ville_id" 
                                id="ville-select"
                                class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent text-gray-900">
                            <option value="">Toutes les villes</option>
                            @foreach($villes as $ville)
                                <option value="{{ $ville->id }}" {{ request('ville_id') == $ville->id ? 'selected' : '' }}>
                                    {{ $ville->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i data-lucide="map" class="w-4 h-4 inline mr-1"></i>
                            Commune
                        </label>
                        <select name="commune_id" 
                                id="commune-select"
                                class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent text-gray-900"
                                {{ !request('ville_id') ? 'disabled' : '' }}>
                            <option value="">Toutes les communes</option>
                            @foreach($communes ?? [] as $commune)
                                @if(request('ville_id') == $commune->ville_id)
                                    <option value="{{ $commune->id }}" {{ request('commune_id') == $commune->id ? 'selected' : '' }}>
                                        {{ $commune->name }}
                                    </option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>

                <button type="submit"
                        class="w-full bg-orange-500 hover:bg-orange-600 text-white px-6 py-3 rounded-xl font-medium transition-colors flex items-center justify-center gap-2">
                    <i data-lucide="search" class="w-5 h-5"></i>
                    Rechercher
                </button>
            </form>
        </div>
    </div>

    <!-- SECTION CATEGORIES -->
    <section class="max-w-7xl mx-auto px-6 mt-24">
        <div class="mb-8">
            <h2 class="text-3xl font-bold text-gray-900">Catégories populaires</h2>
            <p class="text-gray-500 mt-2">Explorez par type de cuisine</p>
        </div>

        <div id="categoriesList" class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
            @forelse($categories as $category)
                @php
                    $categoryIcon = 'utensils';
                    $bgClass = 'bg-orange-50 group-hover:bg-orange-100 text-orange-500';
                    
                    $name = $category->name;
                    
                    if (stripos($name, 'Africain') !== false || stripos($name, 'Ivoirien') !== false) {
                        $categoryIcon = 'flame';
                    } elseif (stripos($name, 'Attiéké') !== false || stripos($name, 'Poisson') !== false) {
                        $categoryIcon = 'fish';
                        $bgClass = 'bg-blue-50 group-hover:bg-blue-100 text-blue-500';
                    } elseif (stripos($name, 'Viande') !== false || stripos($name, 'Grillade') !== false || stripos($name, 'Braise') !== false || stripos($name, 'Brochette') !== false) {
                        $categoryIcon = 'beef';
                        $bgClass = 'bg-red-50 group-hover:bg-red-100 text-red-500';
                    } elseif (stripos($name, 'Poulet') !== false) {
                        $categoryIcon = 'drumstick';
                    } elseif (stripos($name, 'Riz') !== false) {
                        $categoryIcon = 'wheat';
                        $bgClass = 'bg-amber-50 group-hover:bg-amber-100 text-amber-500';
                    } elseif (stripos($name, 'Légumes') !== false || stripos($name, 'Gombo') !== false) {
                        $categoryIcon = 'salad';
                        $bgClass = 'bg-green-50 group-hover:bg-green-100 text-green-500';
                    } elseif (stripos($name, 'Pizza') !== false) {
                        $categoryIcon = 'pizza';
                        $bgClass = 'bg-red-50 group-hover:bg-red-100 text-red-500';
                    } elseif (stripos($name, 'Burger') !== false || stripos($name, 'Sandwich') !== false) {
                        $categoryIcon = 'sandwich';
                    } elseif (stripos($name, 'Soupe') !== false || stripos($name, 'Sauce') !== false) {
                        $categoryIcon = 'soup';
                        $bgClass = 'bg-red-50 group-hover:bg-red-100 text-red-500';
                    } elseif (stripos($name, 'Dessert') !== false || stripos($name, 'Gâteau') !== false) {
                        $categoryIcon = 'cake';
                        $bgClass = 'bg-pink-50 group-hover:bg-pink-100 text-pink-500';
                    } elseif (stripos($name, 'Boisson') !== false) {
                        $categoryIcon = 'cup-soda';
                        $bgClass = 'bg-blue-50 group-hover:bg-blue-100 text-blue-500';
                    } elseif (stripos($name, 'Jus') !== false) {
                        $categoryIcon = 'glass-water';
                        $bgClass = 'bg-green-50 group-hover:bg-green-100 text-green-500';
                    } elseif (stripos($name, 'Alloco') !== false) {
                        $categoryIcon = 'banana';
                        $bgClass = 'bg-yellow-50 group-hover:bg-yellow-100 text-yellow-500';
                    }
                @endphp
                
                <a href="{{ route('search', ['category_id' => $category->id]) }}"
                   class="block bg-white hover:bg-gray-50 border border-gray-100 hover:border-orange-200 p-6 rounded-xl shadow-sm hover:shadow-md transition-all cursor-pointer text-center group">
                    
                    <div class="{{ $bgClass }} w-14 h-14 rounded-xl flex items-center justify-center mx-auto mb-3 transition-colors">
                        <i data-lucide="{{ $categoryIcon }}" class="w-7 h-7"></i>
                    </div>
                    
                    <p class="font-semibold text-gray-800 text-sm">{{ $category->name }}</p>
                    <p class="text-xs text-gray-500 mt-1">{{ $category->products_count ?? 0 }} plats</p>
                </a>
            @empty
                <div class="col-span-full text-center py-8">
                    <i data-lucide="grid-3x3" class="w-12 h-12 text-gray-300 mx-auto mb-2"></i>
                    <p class="text-gray-400">Aucune catégorie disponible</p>
                </div>
            @endforelse
        </div>
    </section>

    <!-- VENDEURS POPULAIRES -->
    <section class="max-w-7xl mx-auto px-6 mt-24">
        <div class="mb-8">
            <h2 class="text-3xl font-bold text-gray-900">Nos meilleurs vendeurs</h2>
            <p class="text-gray-500 mt-2">Découvrez les cuisiniers les plus appréciés de la communauté</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @forelse($vendors->take(8) as $vendor)
                <a href="{{ route('vendeur.store.show', $vendor->id) }}" class="bg-white border border-gray-100 shadow-sm rounded-2xl hover:shadow-xl transition-all overflow-hidden group">
                    <div class="relative">
                        <div class="h-24 bg-gradient-to-br from-orange-400 to-orange-600 transition-all group-hover:h-28"></div>
                        
                        <div class="absolute -bottom-10 left-1/2 transform -translate-x-1/2">
                            <div class="w-20 h-20 rounded-full border-4 border-white bg-gray-50 overflow-hidden shadow-md">
                                @if($vendor->photo)
                                    <img src="{{ asset('storage/' . $vendor->photo) }}" 
                                         alt="{{ $vendor->nom }}" 
                                         class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                                @else
                                    <div class="w-full h-full bg-orange-50 flex items-center justify-center text-orange-400">
                                        <i data-lucide="chef-hat" class="w-10 h-10"></i>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <div class="pt-14 pb-6 px-6 text-center">
                        <h3 class="text-lg font-bold text-gray-900 mb-1 group-hover:text-orange-500 transition-colors">
                            {{ $vendor->nom }}
                        </h3>
                        <p class="text-xs text-gray-500 mb-4 line-clamp-1">
                            {{ $vendor->bio ?? 'Cuisinier passionné' }}
                        </p>
                        
                        <div class="flex items-center justify-center gap-3 text-[10px] text-gray-400 font-bold uppercase tracking-widest border-t border-gray-50 pt-4 group-hover:text-orange-600">
                            <span>Voir la boutique</span>
                            <i data-lucide="arrow-right" class="w-3 h-3 transform group-hover:translate-x-1 transition-transform"></i>
                        </div>
                    </div>
                </a>
            @empty
                <div class="col-span-full text-center py-12 bg-gray-50 rounded-2xl border-2 border-dashed border-gray-200">
                    <i data-lucide="users" class="w-12 h-12 text-gray-300 mx-auto mb-2"></i>
                    <p class="text-gray-400 font-medium">Aucun vendeur disponible pour le moment.</p>
                </div>
            @endforelse
        </div>
    </section>

    <!-- PLATS POPULAIRES -->
    <section class="max-w-7xl mx-auto px-6 mt-24 mb-24">
        <div class="mb-8 flex justify-between items-end">
            <div>
                <h2 class="text-3xl font-bold text-gray-900">Plats populaires</h2>
                <p class="text-gray-500 mt-2">Découvrez nos plats les plus appréciés</p>
            </div>
            <span class="text-orange-500 font-semibold text-sm">{{ $meals->count() }} plats trouvés</span>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
            @forelse($meals as $meal)
                <div class="bg-white rounded-[2rem] p-3 shadow-sm hover:shadow-xl transition-all duration-300 group border border-gray-100">
                    <div class="relative overflow-hidden rounded-[1.8rem] h-52 mb-4">
                        <div class="absolute top-3 right-3 z-10">
                            <span class="bg-white/90 backdrop-blur px-3 py-1.5 rounded-xl text-gray-900 font-bold shadow-sm text-sm border border-orange-50">
                                {{ number_format($meal->price, 0, ',', ' ') }} <small class="text-orange-500 font-bold">FCFA</small>
                            </span>
                        </div>

                        <img src="{{ $meal->image ? asset('storage/' . $meal->image) : 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?w=500' }}"
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                             alt="{{ $meal->name }}" />
                        
                        @if(!$meal->is_available)
                            <div class="absolute inset-0 bg-black/40 backdrop-blur-[1px] flex items-center justify-center">
                                <span class="bg-red-500 text-white px-4 py-1.5 rounded-full text-xs font-bold uppercase">Épuisé</span>
                            </div>
                        @endif
                    </div>

                    <div class="px-2 pb-2">
                        <h3 class="text-lg font-bold text-gray-900 mb-1 truncate">{{ $meal->name }}</h3>
                        
                        <div class="flex items-center gap-2 text-xs text-gray-500 mb-4">
                            <i data-lucide="store" class="w-3.5 h-3.5 text-orange-400"></i>
                            <span class="font-medium">{{ $meal->vendor_name }}</span>
                        </div>

                        @php
                            $cleanPhone = preg_replace('/[^0-9]/', '', $meal->vendor_phone);
                            if(strlen($cleanPhone) == 10) $cleanPhone = "225" . $cleanPhone;
                            
                            $msg = "Bonjour " . $meal->vendor_name . ", je souhaiterais commander votre plat : *" . $meal->name . "* (" . number_format($meal->price, 0, ',', ' ') . " FCFA)";
                        @endphp

                        @if($cleanPhone)
                            <a href="https://wa.me/{{ $cleanPhone }}?text={{ urlencode($msg) }}"
                               target="_blank"
                               class="w-full inline-flex justify-center items-center gap-2 bg-[#25D366] hover:bg-[#1da851] text-white font-bold py-3 px-4 rounded-xl transition-all shadow-md shadow-green-100">
                                <i data-lucide="message-circle" class="w-5 h-5"></i>
                                Commander sur WhatsApp
                            </a>
                        @else
                            <button disabled class="w-full bg-gray-100 text-gray-400 py-3 rounded-xl cursor-not-allowed text-sm font-bold">
                                Contact indisponible
                            </button>
                        @endif
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-16 bg-white rounded-3xl border border-dashed border-gray-200">
                    <i data-lucide="utensils-crossed" class="w-12 h-12 text-gray-300 mx-auto mb-4"></i>
                    <p class="text-gray-500 font-medium">Aucun plat n'est disponible pour le moment.</p>
                </div>
            @endforelse
        </div>
    </section>

    <!-- SECTION HOW IT WORKS -->
    <section class="py-24 bg-gray-50">
        <div class="max-w-7xl mx-auto px-6 text-center">
            <h2 class="text-4xl font-bold text-gray-900 mb-4">Comment ça marche ?</h2>
            <p class="text-lg text-gray-600 mb-16 max-w-2xl mx-auto">Découvrez en 3 étapes simples comment profiter des meilleurs plats disponibles</p>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white rounded-2xl shadow-sm hover:shadow-md transition-all duration-300 p-8 border border-gray-100">
                    <div class="bg-blue-500 w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-6">
                        <i data-lucide="search" class="w-8 h-8 text-white"></i>
                    </div>
                    <div class="inline-block bg-blue-50 text-blue-600 px-3 py-1 rounded-full text-sm font-semibold mb-4">Étape 1</div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Rechercher</h3>
                    <p class="text-gray-600 leading-relaxed">Trouvez les plats qui vous font envie parmi notre sélection de cuisiniers</p>
                </div>

                <div class="bg-white rounded-2xl shadow-sm hover:shadow-md transition-all duration-300 p-8 border border-gray-100">
                    <div class="bg-green-500 w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-6">
                        <i data-lucide="check-circle" class="w-8 h-8 text-white"></i>
                    </div>
                    <div class="inline-block bg-green-50 text-green-600 px-3 py-1 rounded-full text-sm font-semibold mb-4">Étape 2</div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Choisir</h3>
                    <p class="text-gray-600 leading-relaxed">Sélectionnez votre plat préféré et personnalisez votre commande selon vos goûts</p>
                </div>

                <div class="bg-white rounded-2xl shadow-sm hover:shadow-md transition-all duration-300 p-8 border border-gray-100">
                    <div class="bg-orange-500 w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-6">
                        <i data-lucide="shopping-cart" class="w-8 h-8 text-white"></i>
                    </div>
                    <div class="inline-block bg-orange-50 text-orange-600 px-3 py-1 rounded-full text-sm font-semibold mb-4">Étape 3</div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Commander</h3>
                    <p class="text-gray-600 leading-relaxed">Contactez le vendeur et récupérez votre commande directement</p>
                </div>
            </div>
        </div>
    </section>


    <!-- SECTION CTA -->
    <section class="bg-gradient-to-br from-orange-500 to-orange-600 py-20 text-white text-center">
        <div class="max-w-4xl mx-auto px-6">
            <div class="inline-flex items-center gap-2 bg-white/20 backdrop-blur-sm px-4 py-2 rounded-full text-sm font-medium mb-6">
                <i data-lucide="trending-up" class="w-4 h-4"></i>
                Rejoignez notre communauté
            </div>
            <h2 class="text-4xl md:text-5xl font-bold mb-6">Devenez vendeur FoodConnect</h2>
            <p class="text-xl mb-10 max-w-2xl mx-auto text-white/90 leading-relaxed">
                Commencez à vendre vos meilleurs plats faits maison et augmentez vos revenus dès aujourd'hui.
            </p>

            <a href="{{ route('register') }}" class="inline-flex items-center gap-2 bg-white text-orange-600 px-8 py-4 rounded-xl font-bold text-lg hover:bg-gray-100 transition shadow-xl hover:shadow-2xl transform hover:-translate-y-1 justify-center text-center">
                <i data-lucide="chef-hat" class="w-6 h-6"></i> 
                <span>Je veux vendre mes plats</span>
                <i data-lucide="arrow-right" class="w-5 h-5"></i>
            </a>
        </div>
    </section>
</main>
 <!-- FOOTER -->
<footer class="bg-gray-900 text-white py-16 mt-auto">
    <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 md:grid-cols-4 gap-12">
        
        <div class="md:col-span-2">
            <div class="flex items-center gap-3 mb-4">
                <div class="p-2 bg-orange-500 rounded-xl">
                    <i data-lucide="utensils-crossed" class="w-6 h-6 text-white"></i>
                </div>
                <div class="text-2xl font-bold font-lobster">
                    FoodConnect<span class="text-orange-500">.ci</span>
                </div>
            </div>
            <p class="text-gray-400 leading-relaxed mb-6">
                Découvrez les meilleurs plats chez nos cuisiniers.
                Soutenez les talents culinaires et savourez l'authenticité.
            </p>
            <div class="flex gap-4">
                <a href="#" class="w-10 h-10 bg-white/10 hover:bg-white/20 rounded-lg flex items-center justify-center transition">
                    <i data-lucide="facebook" class="w-5 h-5"></i>
                </a>
                <a href="#" class="w-10 h-10 bg-white/10 hover:bg-white/20 rounded-lg flex items-center justify-center transition">
                    <i data-lucide="instagram" class="w-5 h-5"></i>
                </a>
                <a href="#" class="w-10 h-10 bg-white/10 hover:bg-white/20 rounded-lg flex items-center justify-center transition">
                    <i data-lucide="twitter" class="w-5 h-5"></i>
                </a>
            </div>
        </div>

        <div>
            <h3 class="text-lg font-bold mb-4">Navigation</h3>
            <ul class="space-y-3 text-gray-400">
                <li><a href="{{route('home')}}" class="hover:text-white transition">Accueil</a></li>
                <li><a href="{{route('search')}}" class="hover:text-white transition">Explorer</a></li>
                <li><a href="{{route('login')}}" class="hover:text-white transition">Connexion</a></li>
                <li><a href="{{route('register')}}" class="hover:text-white transition">Devenir vendeur</a></li>
            </ul>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-6 mt-12 pt-8 border-t border-gray-800">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4 text-gray-400 text-sm">
            <p>© 2025 FoodConnect.ci — V.B</p>
        </div>
    </div>
</footer>



    <!-- Script pour initialiser Lucide et gérer les communes dynamiquement -->
    <script>
        // Initialiser les icônes Lucide
        document.addEventListener('DOMContentLoaded', function() {
            lucide.createIcons();
        });

        // Données des communes chargées depuis la base de données
        const communesData = @json($communes ?? []);

        // Gestion du changement de ville
document.getElementById('ville-select').addEventListener('change', function() {
    const villeId = this.value;
    const communeSelect = document.getElementById('commune-select');
    
    communeSelect.innerHTML = '<option value="">Toutes les communes</option>';
    
    if (villeId) {
        communeSelect.disabled = false;
        const communesFiltrees = communesData.filter(commune => commune.ville_id == villeId);
        
        communesFiltrees.forEach(commune => {
            const option = document.createElement('option');
            option.value = commune.id;
            option.textContent = commune.name;
            communeSelect.appendChild(option);
        });
    } else {
        communeSelect.disabled = true;
    }
});
    </script>
</body>
</html>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Espace Vendeur - FoodConnect</title>
    
    <link rel="shortcut icon" href="{{ asset('images/Logo FoodConnect.ci en dégradé chaleureux.png') }}" type="image/x-icon">
    @vite('resources/css/app.css')
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="bg-[#FAFAFA] text-slate-800 antialiased font-sans">

<div class="flex flex-col md:flex-row min-h-screen">
    <aside class="w-full md:w-64 bg-white border-r border-slate-100 flex flex-col fixed md:relative h-full z-50">
        <div class="p-8">
            <div class="text-2xl font-black bg-gradient-to-r from-orange-600 to-orange-400 bg-clip-text text-transparent italic tracking-tighter">
                FoodConnect.ci
            </div>
            <p class="text-[10px] uppercase tracking-[0.2em] font-bold text-slate-400 mt-1">Espace Restaurateur</p>
        </div>

        <nav class="flex-1 px-4 space-y-1">
            <a href="{{ route('vendeur.dashboard') }}" 
               class="flex items-center gap-3 px-4 py-3 rounded-2xl transition-all {{ request()->routeIs('vendeur.dashboard') ? 'bg-orange-50 text-orange-600 shadow-sm shadow-orange-100' : 'text-slate-500 hover:bg-slate-50' }}">
                <i data-lucide="layout-dashboard" class="w-5 h-5"></i>
                <span class="font-bold text-sm">Tableau de bord</span>
            </a>

            <a href="{{ route('vendeur.products.create') }}" 
               class="flex items-center gap-3 px-4 py-3 rounded-2xl transition-all {{ request()->routeIs('vendeur.products.*') ? 'bg-orange-50 text-orange-600 shadow-sm shadow-orange-100' : 'text-slate-500 hover:bg-slate-50' }}">
                <i data-lucide="utensils-crossings" class="w-5 h-5"></i>
                <span class="font-bold text-sm">Mes Produits</span>
            </a>

          
        </nav>

        <div class="p-4 md:p-8 border-t border-slate-50">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 rounded-2xl text-red-400 hover:bg-red-50 hover:text-red-600 transition-all font-bold text-sm">
                    <i data-lucide="log-out" class="w-5 h-5"></i>
                    Déconnexion
                </button>
            </form>
        </div>
    </aside>

    <main class="flex-1 md:ml-64">
        <header class="h-20 bg-white/80 backdrop-blur-md border-b border-slate-100 sticky top-0 z-40 px-4 md:px-8 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <span class="text-slate-400 text-sm font-medium italic">Bienvenue,</span>
                <span class="text-slate-900 font-black text-sm uppercase">{{ auth()->user()->name }}</span>
            </div>
            
            <div class="flex items-center gap-3 px-4 py-2 rounded-full border {{ auth()->user()->is_open ? 'border-green-100 bg-green-50 text-green-600' : 'border-red-100 bg-red-50 text-red-600' }}">
                <span class="relative flex h-2 w-2">
                    @if(auth()->user()->is_open)
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                    @endif
                    <span class="relative inline-flex rounded-full h-2 w-2 {{ auth()->user()->is_open ? 'bg-green-500' : 'bg-red-500' }}"></span>
                </span>
                <span class="text-[10px] font-black uppercase tracking-widest">
                    {{ auth()->user()->is_open ? 'Boutique Ouverte' : 'Boutique Fermée' }}
                </span>
            </div>
        </header>

        <div class="p-8">
            @yield('content')
        </div>
    </main>
</div>

<script>
    // Initialisation des icônes Lucide
    lucide.createIcons();
</script>
</body>
</html>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FoodConnect.ci</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&family=Lobster&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
     <link rel="shortcut icon" href="{{ asset('images/Logo FoodConnect.ci en dégradé chaleureux.png') }}" type="image/x-icon">
        
       
    
</head>
<body class="bg-[#fffcf9] font-poppins">

    <nav class="bg-white border-b border-gray-100 sticky top-0 z-50 py-4">
        <div class="max-w-7xl mx-auto px-6 flex justify-between items-center">
            <a href="{{ route('home') }}" class="flex items-center gap-2 group">
                <div class="p-1.5 bg-orange-500 rounded-lg group-hover:rotate-12 transition-transform">
                    <i data-lucide="utensils-crossed" class="w-5 h-5 text-white"></i>
                </div>
                <span class="text-xl font-bold font-lobster text-gray-900">FoodConnect<span class="text-orange-500">.ci</span></span>
            </a>

            <div class="flex items-center gap-4">
                <a href="{{ route('search') }}" class="text-gray-600 hover:text-orange-500 p-2"><i data-lucide="search"></i></a>
                @auth
                    <a href="{{ route('dashboard') }}" class="bg-gray-100 text-gray-700 px-4 py-2 rounded-xl text-sm font-bold hover:bg-orange-500 hover:text-white transition-all">Mon compte</a>
                @else
                    <a href="{{ route('login') }}" class="text-gray-700 font-bold text-sm">Connexion</a>
                @endauth
            </div>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    <footer class="py-10 text-center text-gray-400 text-sm border-t border-gray-100 mt-20">
        <p>© 2025 FoodConnect.ci — Fait avec passion</p>
    </footer>

    <script>
        lucide.createIcons(); // Pour que les icônes marchent sur TOUTES les pages utilisant ce layout
    </script>
</body>
</html>
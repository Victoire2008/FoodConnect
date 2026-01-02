<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - FoodConnect</title>
      
     @vite('resources/css/app.css')
      <link rel="shortcut icon" href="{{ asset('images/Logo FoodConnect.ci en dégradé chaleureux.png') }}" type="image/x-icon">
</head>
<body class="bg-gradient-to-br from-slate-50 to-slate-100 min-h-screen">

    <!-- HEADER -->
    <header class="bg-white/80 backdrop-blur-md border-b border-slate-200 sticky top-0 z-10">
        <div class="max-w-7xl mx-auto px-8 py-5 flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-light text-slate-800 tracking-tight">Tableau de bord</h1>
                <p class="text-sm text-slate-500 mt-1">Gestion de la plateforme</p>
            </div>
            <a href="{{ route('home') }}" class="text-slate-600 hover:text-slate-900 transition-colors text-sm flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                Accueil
            </a>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-8 py-8">
        <!-- Messages de succès -->
        @if(session('success'))
            <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-700 px-5 py-4 rounded-xl flex items-center gap-3 shadow-sm">
                <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <span class="text-sm">{{ session('success') }}</span>
            </div>
        @endif

        <!-- STATISTICS -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-10">
            <div class="bg-white p-6 rounded-2xl border border-slate-200 hover:shadow-xl hover:-translate-y-1 transition-all duration-200">
                <div class="flex items-start justify-between mb-3">
                    <p class="text-sm text-slate-500 font-light">Total Plats</p>
                    <div class="w-10 h-10 rounded-lg bg-blue-50 flex items-center justify-center">
                        <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/>
                            <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                </div>
                <p class="text-3xl font-light text-slate-800">{{ $productsCount }}</p>
            </div>
            
            <div class="bg-white p-6 rounded-2xl border border-slate-200 hover:shadow-xl hover:-translate-y-1 transition-all duration-200">
                <div class="flex items-start justify-between mb-3">
                    <p class="text-sm text-slate-500 font-light">En attente</p>
                    <div class="w-10 h-10 rounded-lg bg-orange-50 flex items-center justify-center">
                        <svg class="w-5 h-5 text-orange-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                </div>
                <p class="text-3xl font-light text-orange-600">{{ $pendingProducts }}</p>
            </div>
            
            <div class="bg-white p-6 rounded-2xl border border-slate-200 hover:shadow-xl hover:-translate-y-1 transition-all duration-200">
                <div class="flex items-start justify-between mb-3">
                    <p class="text-sm text-slate-500 font-light">Catégories</p>
                    <div class="w-10 h-10 rounded-lg bg-purple-50 flex items-center justify-center">
                        <svg class="w-5 h-5 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z"/>
                        </svg>
                    </div>
                </div>
                <p class="text-3xl font-light text-slate-800">{{ $categoriesCount }}</p>
            </div>
            
            <div class="bg-white p-6 rounded-2xl border border-slate-200 hover:shadow-xl hover:-translate-y-1 transition-all duration-200">
                <div class="flex items-start justify-between mb-3">
                    <p class="text-sm text-slate-500 font-light">Vendeurs</p>
                    <div class="w-10 h-10 rounded-lg bg-emerald-50 flex items-center justify-center">
                        <svg class="w-5 h-5 text-emerald-600" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/>
                        </svg>
                    </div>
                </div>
                <p class="text-3xl font-light text-slate-800">{{ $vendorsCount }}</p>
            </div>
        </div>

        <!-- GESTION DES CATÉGORIES -->
        <div class="bg-white rounded-2xl border border-slate-200 mb-8 overflow-hidden shadow-sm">
            <div class="px-6 py-5 border-b border-slate-200 flex justify-between items-center">
                <div>
                    <h2 class="text-lg font-light text-slate-800 tracking-tight">Catégories</h2>
                    <p class="text-sm text-slate-500 mt-1">Gérer les catégories de plats</p>
                </div>
                <button onclick="document.getElementById('addCategoryForm').classList.toggle('hidden')" 
                        class="bg-slate-800 text-white px-5 py-2.5 rounded-xl hover:bg-slate-900 transition-all text-sm font-light flex items-center gap-2 shadow-sm hover:shadow-md">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Ajouter
                </button>
            </div>

            <!-- Formulaire d'ajout -->
            <div id="addCategoryForm" class="hidden bg-slate-50 px-6 py-5 border-b border-slate-200">
                <form method="POST" action="{{ route('admin.categories.store') }}" class="flex gap-3">
                    @csrf
                    <input type="text" 
                           name="name"
                           placeholder="Nom de la catégorie" 
                           class="flex-1 border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-slate-400 focus:border-transparent"
                           required>
                    <input type="text" 
                           name="description"
                           placeholder="Description" 
                           class="flex-1 border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-slate-400 focus:border-transparent">
                    <button type="submit" class="bg-emerald-600 text-white px-6 py-2.5 rounded-xl hover:bg-emerald-700 transition-colors text-sm font-light">
                        Enregistrer
                    </button>
                    <button type="button" 
                            onclick="document.getElementById('addCategoryForm').classList.add('hidden')"
                            class="bg-white border border-slate-300 text-slate-700 px-6 py-2.5 rounded-xl hover:bg-slate-50 transition-colors text-sm font-light">
                        Annuler
                    </button>
                </form>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-slate-50 border-b border-slate-200">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Nom</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Description</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-slate-500 uppercase tracking-wider">Plats</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-slate-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        @forelse($categories as $category)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4 text-sm text-slate-900">{{ $category->name }}</td>
                            <td class="px-6 py-4 text-sm text-slate-500">{{ $category->description ?? 'Aucune description' }}</td>
                            <td class="px-6 py-4 text-sm text-slate-900 text-center">{{ $category->products_count ?? 0 }}</td>
                            <td class="px-6 py-4 text-sm text-right">
                                <button onclick="editCategory({{ $category->id }}, '{{ $category->name }}', '{{ $category->description }}')" class="text-slate-600 hover:text-slate-900 mr-3 transition-colors">Modifier</button>
                                <form method="POST" action="{{ route('admin.categories.destroy', $category) }}" class="inline" onsubmit="return confirm('Êtes-vous sûr ?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-700 transition-colors">Supprimer</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-8 text-center text-slate-500 text-sm">
                                Aucune catégorie disponible. Ajoutez-en une pour commencer.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Modal Modification -->
        <div id="editCategoryForm" class="hidden fixed inset-0 bg-slate-900/50 backdrop-blur-sm flex items-center justify-center z-50">
            <div class="bg-white p-8 rounded-2xl shadow-2xl w-full max-w-md">
                <h3 class="text-xl font-light text-slate-800 mb-6">Modifier la catégorie</h3>
                <form id="editForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-5">
                        <label class="block text-sm text-slate-600 mb-2 font-light">Nom</label>
                        <input type="text" 
                               name="name" 
                               id="editName"
                               class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-slate-400 focus:border-transparent"
                               required>
                    </div>
                    <div class="mb-6">
                        <label class="block text-sm text-slate-600 mb-2 font-light">Description</label>
                        <input type="text" 
                               name="description" 
                               id="editDescription"
                               class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-slate-400 focus:border-transparent">
                    </div>
                    <div class="flex gap-3">
                        <button type="submit" class="flex-1 bg-slate-800 text-white px-4 py-2.5 rounded-xl hover:bg-slate-900 transition-colors font-light">
                            Enregistrer
                        </button>
                        <button type="button" 
                                onclick="document.getElementById('editCategoryForm').classList.add('hidden')"
                                class="flex-1 bg-white border border-slate-300 text-slate-700 px-4 py-2.5 rounded-xl hover:bg-slate-50 transition-colors font-light">
                            Annuler
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- PLATS EN ATTENTE -->
        <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-sm mt-8">
    <div class="px-6 py-5 border-b border-slate-200 flex justify-between items-center">
        <div>
            <h2 class="text-lg font-light text-slate-800 tracking-tight">Catalogue Global</h2>
            <p class="text-sm text-slate-500 mt-1">Modérer tous les plats en ligne</p>
        </div>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-slate-50 border-b border-slate-200">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Plat</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Vendeur</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-slate-500 uppercase tracking-wider">Prix</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-slate-500 uppercase tracking-wider">Statut</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-slate-500 uppercase tracking-wider">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200">
                @foreach($products as $product)
                <tr class="hover:bg-slate-50 transition-colors">
                    <td class="px-6 py-4 flex items-center gap-3">
                        <img src="{{ asset('storage/' . $product->image) }}" class="w-10 h-10 rounded-lg object-cover shadow-sm">
                        <span class="text-sm font-medium text-slate-900">{{ $product->name }}</span>
                    </td>
                    <td class="px-6 py-4 text-sm text-slate-600 font-light">
                        {{ $product->user->name }}
                    </td>
                    <td class="px-6 py-4 text-center text-sm font-bold text-slate-700">
                        {{ number_format($product->prix, 0, ',', ' ') }} FCFA
                    </td>
                    <td class="px-6 py-4 text-center">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-medium {{ $product->is_active ? 'bg-emerald-50 text-emerald-700' : 'bg-slate-100 text-slate-500' }}">
                            {{ $product->is_active ? 'VISIBLE' : 'MASQUÉ' }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <form method="POST" action="{{ route('admin.products.toggle', $product) }}">
                            @csrf
                            @method('PATCH')
                            <button class="text-xs font-bold {{ $product->is_active ? 'text-orange-500' : 'text-emerald-600' }} hover:underline">
                                {{ $product->is_active ? 'Désactiver' : 'Activer' }}
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

            </div>
        </div>
       <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-sm">
    <div class="px-6 py-5 border-b border-slate-200 flex justify-between items-center">
        <div>
            <h2 class="text-lg font-light text-slate-800 tracking-tight">Vendeurs</h2>
            <p class="text-sm text-slate-500 mt-1">Gérer les comptes et l'ouverture des boutiques</p>
        </div>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-slate-50 border-b border-slate-200">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Nom</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-slate-500 uppercase tracking-wider">Boutique</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-slate-500 uppercase tracking-wider">Plats</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-slate-500 uppercase tracking-wider">Compte</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-slate-500 uppercase tracking-wider">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200">
                @forelse($vendorsList as $vendor)
                <tr class="hover:bg-slate-50 transition-colors">
                    <td class="px-6 py-4">
                        <div class="text-sm font-medium text-slate-900">{{ $vendor->name }}</div>
                        <div class="text-xs text-slate-500">{{ $vendor->email }}</div>
                    </td>
                    
                    <td class="px-6 py-4 text-center">
                        <form method="POST" action="{{ route('admin.vendeurs.toggle-open', $vendor) }}">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="inline-flex items-center gap-2 px-3 py-1.5 rounded-xl border transition-all {{ $vendor->is_open ? 'bg-emerald-50 border-emerald-100 text-emerald-600' : 'bg-slate-100 border-slate-200 text-slate-500' }}">
                                <span class="relative flex h-2 w-2">
                                    @if($vendor->is_open)
                                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                                    @endif
                                    <span class="relative inline-flex rounded-full h-2 w-2 {{ $vendor->is_open ? 'bg-emerald-500' : 'bg-slate-400' }}"></span>
                                </span>
                                <span class="text-[10px] font-bold uppercase tracking-tight">
                                    {{ $vendor->is_open ? 'Ouverte' : 'Fermée' }}
                                </span>
                            </button>
                        </form>
                    </td>

                    <td class="px-6 py-4 text-sm text-slate-900 text-center font-light">{{ $vendor->products_count }}</td>
                    
                    <td class="px-6 py-4 text-center">
                        @if($vendor->is_active)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-medium bg-blue-50 text-blue-700 uppercase">Actif</span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-medium bg-red-50 text-red-700 uppercase">Suspendu</span>
                        @endif
                    </td>

                    <td class="px-6 py-4 text-right">
                        <div class="flex justify-end gap-3">
                            <form method="POST" action="{{ route('admin.vendeurs.toggle', $vendor) }}">
                                @csrf
                                @method('PUT')
                                <button class="text-xs {{ $vendor->is_active ? 'text-red-500 hover:text-red-700' : 'text-emerald-600 hover:text-emerald-700' }} transition-colors underline decoration-dotted underline-offset-4">
                                    {{ $vendor->is_active ? 'Suspendre' : 'Activer' }}
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
    </main>

    <script>
        function editCategory(id, name, description) {
            document.getElementById('editForm').action = `/admin/categories/${id}`;
            document.getElementById('editName').value = name;
            document.getElementById('editDescription').value = description || '';
            document.getElementById('editCategoryForm').classList.remove('hidden');
        }
    </script>
</body>
</html>
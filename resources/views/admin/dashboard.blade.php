<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - FoodConnect</title>
    @vite('resources/css/app.css')
    {{-- On ajoute Lucide Icons pour plus de modernité --}}
    <script src="https://unpkg.com/lucide@latest"></script>
    <link rel="shortcut icon" href="{{ asset('images/Logo FoodConnect.ci en dégradé chaleureux.png') }}" type="image/x-icon">
</head>
<body class="bg-[#f8fafc] min-h-screen font-sans antialiased text-slate-900">

    <nav class="bg-white border-b border-slate-200 sticky top-0 z-50 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <div class="flex items-center gap-4">
                    <div class="bg-slate-900 p-2 rounded-lg">
                        <i data-lucide="layout-dashboard" class="text-white w-5 h-5"></i>
                    </div>
                    <div>
                        <h1 class="text-lg font-bold tracking-tight">Panneau d'administration</h1>
                        <p class="text-[10px] uppercase tracking-widest text-slate-400 font-bold">FoodConnect.ci</p>
                    </div>
                </div>
                <div class="flex items-center gap-4">
                    <a href="{{ route('home') }}" class="flex items-center gap-2 px-4 py-2 text-sm font-medium text-slate-600 hover:bg-slate-50 rounded-xl transition-all">
                        <i data-lucide="external-link" class="w-4 h-4"></i>
                        Voir le site
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        
        @if(session('success'))
        <div class="mb-8 bg-emerald-50 border border-emerald-100 p-4 rounded-2xl flex items-center gap-3 animate-in fade-in slide-in-from-top-4">
            <div class="bg-emerald-500 p-1 rounded-full text-white">
                <i data-lucide="check" class="w-4 h-4"></i>
            </div>
            <p class="text-emerald-800 text-sm font-medium">{{ session('success') }}</p>
        </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
            {{-- Card Stat --}}
            <x-admin-stat-card title="Total Plats" value="{{ $productsCount }}" icon="package" color="blue" />
            <x-admin-stat-card title="En attente" value="{{ $pendingProducts }}" icon="clock" color="orange" />
            <x-admin-stat-card title="Catégories" value="{{ $categoriesCount }}" icon="layers" color="purple" />
            <x-admin-stat-card title="Vendeurs" value="{{ $vendorsCount }}" icon="users" color="emerald" />
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <div class="lg:col-span-1 space-y-6">
                <div class="bg-white rounded-[2rem] border border-slate-200 shadow-sm overflow-hidden">
                    <div class="p-6 border-b border-slate-50 flex justify-between items-center">
                        <h3 class="font-bold flex items-center gap-2 italic">
                            <i data-lucide="tag" class="w-4 h-4 text-slate-400"></i>
                            Catégories
                        </h3>
                        <button onclick="toggleElement('addCategoryForm')" class="p-2 hover:bg-slate-50 rounded-full transition-colors text-slate-400">
                            <i data-lucide="plus-circle" class="w-5 h-5"></i>
                        </button>
                    </div>

                    <div id="addCategoryForm" class="hidden p-6 bg-slate-50 border-b border-slate-100">
                        <form method="POST" action="{{ route('admin.categories.store') }}" class="space-y-3">
                            @csrf
                            <input type="text" name="name" placeholder="Nom..." class="w-full px-4 py-2 rounded-xl border-none ring-1 ring-slate-200 focus:ring-2 focus:ring-slate-900 text-sm" required>
                            <button class="w-full py-2 bg-slate-900 text-white rounded-xl text-xs font-bold uppercase tracking-widest hover:bg-slate-800 transition-all">Ajouter</button>
                        </form>
                    </div>

                    <div class="divide-y divide-slate-50 max-h-[400px] overflow-y-auto">
                        @forelse($categories as $category)
                        <div class="p-4 flex items-center justify-between hover:bg-slate-50 transition-colors group">
                            <div>
                                <p class="text-sm font-bold text-slate-700">{{ $category->name }}</p>
                                <p class="text-[10px] text-slate-400 uppercase font-black">{{ $category->products_count ?? 0 }} plats</p>
                            </div>
                            <div class="flex gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                <button onclick="editCategory({{ $category->id }}, '{{ $category->name }}', '{{ $category->description }}')" class="p-1.5 text-slate-400 hover:text-blue-600"><i data-lucide="edit-3" class="w-4 h-4"></i></button>
                                <form method="POST" action="{{ route('admin.categories.destroy', $category) }}" onsubmit="return confirm('Supprimer ?')">
                                    @csrf @method('DELETE')
                                    <button class="p-1.5 text-slate-400 hover:text-red-600"><i data-lucide="trash-2" class="w-4 h-4"></i></button>
                                </form>
                            </div>
                        </div>
                        @empty
                        <p class="p-8 text-center text-xs text-slate-400 italic font-medium text-slate-500 uppercase tracking-widest italic">Aucune catégorie</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <div class="lg:col-span-2 space-y-8">
                
                {{-- SECTION VENDEURS --}}
                <section class="bg-white rounded-[2rem] border border-slate-200 shadow-sm overflow-hidden">
                    <div class="p-6 border-b border-slate-50 flex items-center justify-between">
                        <h3 class="font-bold flex items-center gap-2 italic text-slate-800 tracking-tight">
                            <i data-lucide="store" class="w-4 h-4 text-emerald-500"></i>
                            Gestion des Vendeurs
                        </h3>
                        <span class="text-[10px] font-black bg-emerald-50 text-emerald-600 px-3 py-1 rounded-full uppercase">{{ $vendorsCount }} inscrits</span>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead class="bg-slate-50/50">
                                <tr>
                                    <th class="px-6 py-4 text-[10px] font-black uppercase text-slate-400">Vendeur</th>
                                    <th class="px-6 py-4 text-[10px] font-black uppercase text-slate-400 text-center">Boutique</th>
                                    <th class="px-6 py-4 text-[10px] font-black uppercase text-slate-400 text-center">Compte</th>
                                    <th class="px-6 py-4"></th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-50">
                                @foreach($vendorsList as $vendor)
                                <tr>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-xs font-bold text-slate-500 uppercase">
                                                {{ substr($vendor->name, 0, 2) }}
                                            </div>
                                            <div>
                                                <p class="text-sm font-bold text-slate-700">{{ $vendor->name }}</p>
                                                <p class="text-xs text-slate-400">{{ $vendor->email }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-center font-bold">
                                        <form method="POST" action="{{ route('admin.vendeurs.toggle-open', $vendor) }}">
                                            @csrf @method('PATCH')
                                            <button class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-black uppercase {{ $vendor->is_open ? 'bg-emerald-50 text-emerald-600' : 'bg-slate-100 text-slate-400' }}">
                                                <span class="w-1.5 h-1.5 rounded-full {{ $vendor->is_open ? 'bg-emerald-500 animate-pulse' : 'bg-slate-400' }}"></span>
                                                {{ $vendor->is_open ? 'Ouverte' : 'Fermée' }}
                                            </button>
                                        </form>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="px-2.5 py-1 rounded-lg text-[10px] font-black uppercase {{ $vendor->is_active ? 'bg-blue-50 text-blue-600' : 'bg-red-50 text-red-600' }}">
                                            {{ $vendor->is_active ? 'Actif' : 'Suspendu' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <form method="POST" action="{{ route('admin.vendeurs.toggle', $vendor) }}">
                                            @csrf @method('PUT')
                                            <button class="text-xs font-bold {{ $vendor->is_active ? 'text-red-500' : 'text-emerald-600' }} hover:underline underline-offset-4 uppercase tracking-tighter transition-all">
                                                {{ $vendor->is_active ? 'Bloquer' : 'Débloquer' }}
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </section>

                {{-- SECTION CATALOGUE --}}
                <section class="bg-white rounded-[2rem] border border-slate-200 shadow-sm overflow-hidden">
                    <div class="p-6 border-b border-slate-50 flex items-center justify-between bg-slate-900">
                        <h3 class="font-bold flex items-center gap-2 italic text-white tracking-tight">
                            <i data-lucide="package" class="w-4 h-4 text-blue-400"></i>
                            Catalogue Global
                        </h3>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead class="bg-slate-50/50">
                                <tr>
                                    <th class="px-6 py-4 text-[10px] font-black uppercase text-slate-400">Détails du plat</th>
                                    <th class="px-6 py-4 text-[10px] font-black uppercase text-slate-400 text-center">Prix</th>
                                    <th class="px-6 py-4 text-[10px] font-black uppercase text-slate-400 text-center">Visibilité</th>
                                    <th class="px-6 py-4"></th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-50">
                                @foreach($products as $product)
                                <tr class="hover:bg-slate-50/50 transition-colors">
                                    <td class="px-6 py-4 flex items-center gap-4">
                                        <img src="{{ asset('storage/' . $product->image) }}" class="w-12 h-12 rounded-xl object-cover shadow-sm ring-1 ring-slate-100">
                                        <div>
                                            <p class="text-sm font-bold text-slate-800 leading-none">{{ $product->name }}</p>
                                            <p class="text-[10px] text-slate-400 mt-1 uppercase font-bold tracking-tight">Vendu par <span class="text-slate-600">{{ $vendor->name }}</span></p>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-center font-black text-slate-700 text-sm">
                                        {{ number_format($product->prix, 0, ',', ' ') }} <span class="text-[10px] text-slate-400">CFA</span>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <div class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-black uppercase {{ $product->is_active ? 'bg-emerald-50 text-emerald-600' : 'bg-slate-100 text-slate-400' }}">
                                            {{ $product->is_active ? 'Public' : 'Masqué' }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <form method="POST" action="{{ route('admin.products.toggle', $product) }}">
                                            @csrf @method('PATCH')
                                            <button class="px-4 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all {{ $product->is_active ? 'bg-orange-50 text-orange-600 hover:bg-orange-100' : 'bg-emerald-50 text-emerald-600 hover:bg-emerald-100' }}">
                                                {{ $product->is_active ? 'Désactiver' : 'Activer' }}
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </section>
            </div>
        </div>

        <div id="editCategoryForm" class="hidden fixed inset-0 bg-slate-900/60 backdrop-blur-sm flex items-center justify-center z-[60] p-4">
            <div class="bg-white p-8 rounded-[2.5rem] shadow-2xl w-full max-w-md animate-in zoom-in-95 duration-200">
                <div class="flex items-center gap-4 mb-8">
                    <div class="w-12 h-12 bg-slate-100 rounded-2xl flex items-center justify-center text-slate-400">
                        <i data-lucide="edit-3"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold tracking-tight">Modifier</h3>
                        <p class="text-xs text-slate-400 font-bold uppercase tracking-widest italic">Ajuster la catégorie</p>
                    </div>
                </div>

                <form id="editForm" method="POST" class="space-y-5">
                    @csrf @method('PUT')
                    <div>
                        <label class="block text-[10px] font-black uppercase text-slate-400 mb-2 ml-1">Nom</label>
                        <input type="text" name="name" id="editName" class="w-full px-5 py-3 rounded-2xl border-none ring-1 ring-slate-200 focus:ring-2 focus:ring-slate-900 font-bold shadow-sm" required>
                    </div>
                    <div>
                        <label class="block text-[10px] font-black uppercase text-slate-400 mb-2 ml-1">Description</label>
                        <input type="text" name="description" id="editDescription" class="w-full px-5 py-3 rounded-2xl border-none ring-1 ring-slate-200 focus:ring-2 focus:ring-slate-900 font-medium shadow-sm">
                    </div>
                    <div class="flex gap-3 pt-4">
                        <button type="submit" class="flex-1 py-4 bg-slate-900 text-white rounded-2xl text-xs font-black uppercase tracking-widest hover:bg-slate-800 transition-all shadow-lg shadow-slate-200">Enregistrer</button>
                        <button type="button" onclick="document.getElementById('editCategoryForm').classList.add('hidden')" class="px-6 py-4 bg-slate-50 text-slate-400 rounded-2xl text-xs font-black uppercase tracking-widest hover:bg-slate-100 transition-all">Fermer</button>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <script>
        // Initialisation des icônes
        lucide.createIcons();

        function toggleElement(id) {
            const el = document.getElementById(id);
            el.classList.toggle('hidden');
        }

        function editCategory(id, name, description) {
            document.getElementById('editForm').action = `/admin/categories/${id}`;
            document.getElementById('editName').value = name;
            document.getElementById('editDescription').value = description || '';
            document.getElementById('editCategoryForm').classList.remove('hidden');
        }
    </script>
</body>
</html>
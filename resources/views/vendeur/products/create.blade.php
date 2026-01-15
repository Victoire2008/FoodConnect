<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Product</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

      <link rel="shortcut icon" href="{{ asset('images/Logo FoodConnect.ci en dégradé chaleureux.png') }}" type="image/x-icon">
    @vite('resources/css/app.css')
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="font-inter bg-white-50">
<div class="min-h-screen bg-white-50 py-6 sm:py-10 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto space-y-10">
        <!-- Bouton Retour & Titre -->
        <div class="mb-8">
            <a href="{{ route('vendeur.dashboard') }}" class="inline-flex items-center gap-2 text-orange-500 hover:text-orange-700 transition-colors font-medium text-sm">
                <i data-lucide="chevron-left" class="w-4 h-4"></i>
                Retour
            </a>
            <h1 class="text-xl sm:text-2xl md:text-3xl font-extrabold text-orange-800 leading-tight mt-2">Créer un nouveau produit</h1>
        </div>

        <!-- Formulaire -->
        <form method="POST" action="{{ route('vendeur.products.store') }}" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Image -->
            <div class="bg-white p-4 sm:p-6 rounded-xl shadow-md border border-orange-200">
                <label class="block text-sm font-medium text-orange-600 mb-4">Photo du produit</label>
                <div class="flex flex-col items-center">
                    <div id="dropzone" class="relative group w-full max-w-xs h-40 sm:h-48 rounded-lg overflow-hidden bg-orange-100 border-2 border-dashed border-orange-300 hover:border-orange-500 transition-all flex items-center justify-center cursor-pointer">
                        <input type="file" name="image" id="imageInput" class="hidden" accept="image/*" required>
                        <div id="placeholder-content" class="text-center">
                            <i data-lucide="image-plus" class="w-8 h-8 sm:w-10 sm:h-10 text-orange-400"></i>
                            <p class="text-xs sm:text-sm text-orange-500 mt-2">Cliquez pour ajouter une image</p>
                        </div>
                        <div id="imagePreview" class="absolute inset-0 hidden">
                            <img src="" class="w-full h-full object-cover">
                            <div class="absolute inset-0 bg-black/30 flex items-center justify-center opacity-0 group-hover:opacity-100">
                                <p class="text-white text-xs sm:text-sm">Changer l'image</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Informations générales -->
            <div class="bg-white p-4 sm:p-6 rounded-xl shadow-md border border-orange-200 space-y-4">
                <div>
                    <label class="block text-sm font-medium text-orange-600 mb-2">Nom du produit</label>
                    <input type="text" name="name" value="{{ old('name') }}" placeholder="Ex: Garba Spécial" class="w-full px-3 sm:px-4 py-2 sm:py-3 border border-orange-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:outline-none text-orange-800" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-orange-600 mb-2">Prix</label>
                    <div class="relative">
                        <input type="number" name="prix" value="{{ old('prix') }}" placeholder="1500" class="w-full px-3 sm:px-4 py-2 sm:py-3 border border-orange-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:outline-none text-orange-800" required>
                        <span class="absolute right-3 sm:right-4 top-1/2 transform -translate-y-1/2 text-orange-500">FCFA</span>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-orange-600 mb-2">Catégorie</label>
                    <select name="category_id" class="w-full px-3 sm:px-4 py-2 sm:py-3 border border-orange-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:outline-none text-orange-800" required>
                        <option value="" disabled selected>Choisir une catégorie</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

           
         <!-- Boutons -->
<div class="flex flex-col sm:flex-row justify-center items-center sm:items-center gap-2 sm:gap-4">
    
    <a 
        href="{{ route('vendeur.dashboard') }}"
        class="inline-flex items-center justify-center
               w-auto
               px-3 py-2 sm:px-4 sm:py-2
               bg-orange-100 text-orange-600
               rounded-lg text-xs sm:text-sm
               text-center
               hover:bg-orange-200
               transition duration-200"
    >
        Annuler
    </a>

    <button 
        type="submit"
        class="inline-flex items-center justify-center
               w-auto
               px-3 py-2 sm:px-4 sm:py-2
               bg-orange-600 text-white
               rounded-lg text-xs sm:text-sm
               text-center
               hover:bg-orange-700
               focus:outline-none focus:ring-2 focus:ring-orange-400
               transition duration-200"
    >
        Créer
    </button>

</div>


        </form>
    </div>
</div>

<script>
    const imageInput = document.getElementById('imageInput');
    const dropzone = document.getElementById('dropzone');
    const imagePreview = document.getElementById('imagePreview');
    const placeholder = document.getElementById('placeholder-content');

    dropzone.onclick = () => imageInput.click();

    imageInput.addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                imagePreview.querySelector('img').src = e.target.result;
                imagePreview.classList.remove('hidden');
                placeholder.classList.add('hidden');
            }
            reader.readAsDataURL(file);
        }
    });
</script>
</body>
</html>
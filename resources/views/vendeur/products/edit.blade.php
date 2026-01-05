@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-[#fffcf9] py-8 md:py-12">
    <div class="max-w-3xl mx-auto px-6">
        
        {{-- Header avec Fil d'Ariane --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-10 gap-4">
            <div>
                <a href="{{ route('vendeur.dashboard') }}" class="inline-flex items-center gap-2 text-gray-400 hover:text-orange-500 transition-colors font-bold text-xs uppercase tracking-widest mb-2">
                    <i data-lucide="chevron-left" class="w-4 h-4"></i>
                    Tableau de bord
                </a>
                <h1 class="text-3xl font-black text-gray-900">Modifier mon plat</h1>
            </div>
            
            {{-- Badge Statut Rapide --}}
            <div class="hidden md:flex items-center gap-2 px-4 py-2 bg-white rounded-2xl border border-gray-100 shadow-sm">
                <span class="w-2 h-2 rounded-full {{ $product->is_visible ? 'bg-green-500' : 'bg-gray-300' }}"></span>
                <span class="text-[10px] font-black uppercase text-gray-500">{{ $product->is_visible ? 'En ligne' : 'Brouillon' }}</span>
            </div>
        </div>

        <form action="{{ route('vendeur.products.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            {{-- SECTION IMAGE --}}
            <div class="bg-white p-6 md:p-8 rounded-[2.5rem] shadow-sm border border-gray-100">
                <label class="block text-xs font-black uppercase tracking-widest text-gray-400 mb-4">Visuel du produit</label>
                <div class="flex flex-col md:flex-row gap-8 items-center">
                    <div class="relative group">
                        <div class="w-44 h-44 rounded-[2.2rem] overflow-hidden bg-gray-50 border-2 border-dashed border-gray-200 group-hover:border-orange-300 transition-colors">
                            <img id="preview" src="{{ asset('storage/' . $product->image) }}" class="w-full h-full object-cover">
                        </div>
                        <label for="image-input" class="absolute -bottom-2 -right-2 w-10 h-10 bg-orange-500 text-white rounded-full flex items-center justify-center cursor-pointer shadow-lg hover:scale-110 transition-transform">
                            <i data-lucide="camera" class="w-5 h-5"></i>
                        </label>
                    </div>
                    
                    <div class="flex-1 text-center md:text-left">
                        <h4 class="font-bold text-gray-800 mb-1">Changer la photo</h4>
                        <p class="text-sm text-gray-400 mb-4">Mettez une photo lumineuse pour attirer plus de clients.</p>
                        <input type="file" name="image" id="image-input" class="hidden" accept="image/*">
                        @error('image') <p class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            {{-- SECTION INFOS GÉNÉRALES --}}
            <div class="bg-white p-6 md:p-8 rounded-[2.5rem] shadow-sm border border-gray-100 space-y-6">
                {{-- Nom du plat --}}
                <div>
                    <label class="block text-xs font-black uppercase tracking-widest text-gray-400 mb-2 ml-1">Nom du délice</label>
                    <input type="
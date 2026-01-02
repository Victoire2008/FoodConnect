<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\VendorController as AdminVendorController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController; // AJOUTEZ CETTE LIGNE
use App\Http\Controllers\Vendor\ProductController as VendorProductController;
use Illuminate\Support\Facades\Auth; 
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Vendor\DashboardController as VendorDashboardController;  
use App\Http\Controllers\SearchController;
use Illuminate\Http\Request;
use App\Http\Controllers\VendeurStoreController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/search', [SearchController::class, 'index'])->name('search');
// Cette route est publique : n'importe qui peut voir la boutique du vendeur
Route::get('/boutique/vendeur/{id}', [VendeurStoreController::class, 'show'])->name('vendeur.store.show');

use App\Http\Controllers\VendeurProductController;

// Pour le vendeur : Activer/Désactiver un plat
Route::patch('/vendeur/products/{product}/toggle', [VendorProductController::class, 'toggleStatus'])
    ->name('vendeur.products.toggle')
    ->middleware('auth');

// Pour le client : Compter le clic et rediriger vers WhatsApp
Route::get('/order/{product}/whatsapp', [VendorProductController::class, 'trackClick'])
    ->name('product.whatsapp.click');
// Redirection dashboard selon rôle
Route::get('/dashboard', function () {
    $user = Auth::user();

    if ($user->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }

    if ($user->role === 'vendeur') {
        return redirect()->route('vendeur.dashboard');
    }

    // Cas utilisateur normal
    return view('dashboard');

})->middleware(['auth'])->name('dashboard');

// Routes protégées par auth
Route::middleware(['auth'])->group(function () {

    // Profile routes for all authenticated users
    Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Admin routes
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        // REMPLACEZ CETTE LIGNE :
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        Route::resource('categories', AdminCategoryController::class);
        Route::resource('vendors', AdminVendorController::class);
        Route::patch('vendors/{vendor}/toggle', [AdminVendorController::class, 'toggle'])->name('vendors.toggle');
        Route::resource('products', AdminProductController::class);
        Route::match(['get', 'patch'], 'products/{product}/toggle', [AdminProductController::class, 'toggleProduct'])->name('products.toggle');

        // AJOUTEZ CES ROUTES pour les actions du dashboard
    Route::put('/products/{product}/validate', [AdminProductController::class, 'validate'])
        ->name('products.validate');
    Route::put('/vendeurs/{user}/toggle', [AdminVendorController::class, 'toggle'])
        ->name('vendeurs.toggle');
    Route::patch('/vendeurs/{user}/toggle-open', [AdminVendorController::class, 'toggleOpen'])
        ->name('vendeurs.toggle-open');
    });    
    

     Route::middleware(['auth', 'has.location'])->group(function () {
    Route::get('/vendeur/produits/create', [VendorProductController::class, 'create']);
    Route::post('/vendeur/produits', [VendorProductController::class, 'store']);
});





    // Vendor routes
    Route::middleware('role:vendeur')->prefix('vendeur')->name('vendeur.')->group(function () {

        // Dashboard vendeur (avec données)
        Route::get('/dashboard', [VendorDashboardController::class, 'index'])
            ->name('dashboard');

        // Profil
        Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

        // Produits vendeur (CRUD complet)
        Route::resource('products', VendorProductController::class);
    });



});

require __DIR__.'/auth.php';
<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-[#FAFAFA] p-4 sm:p-6">
        <div class="w-full max-w-md">

            <div class="text-center mb-8 sm:mb-10">
                <div class="text-2xl sm:text-4xl font-black bg-gradient-to-r from-orange-600 to-orange-400 bg-clip-text text-transparent italic tracking-tighter mb-2">
                    FoodConnect.ci
                </div>
                <p class="text-slate-500 font-medium text-sm sm:text-base">Bon retour ! Connectez-vous à votre espace.</p>
            </div>

            <div class="bg-white rounded-[2.5rem] shadow-xl shadow-orange-100/50 border border-orange-50 p-6 sm:p-10">
                
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    <div class="space-y-2">
                        <label for="email" class="text-[10px] font-black uppercase text-slate-400 ml-4 tracking-widest">Votre Email</label>
                        <input id="email" type="email" name="email" :value="old('email')" required autofocus 
                               class="w-full px-6 py-4 rounded-2xl bg-slate-50 border-none focus:ring-2 focus:ring-orange-500 transition-all placeholder:text-slate-300 font-bold text-slate-700"
                               placeholder="exemple@email.com">
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div class="space-y-2">
                        <div class="flex justify-between items-center px-4">
                            <label for="password" class="text-[10px] font-black uppercase text-slate-400 tracking-widest">Mot de passe</label>
                            @if (Route::has('password.request'))
                                <a class="text-[10px] font-bold text-orange-500 hover:text-orange-600 uppercase tracking-tighter" href="{{ route('password.request') }}">
                                    Oublié ?
                                </a>
                            @endif
                        </div>
                        <input id="password" type="password" name="password" required 
                               class="w-full px-6 py-4 rounded-2xl bg-slate-50 border-none focus:ring-2 focus:ring-orange-500 transition-all placeholder:text-slate-300 font-bold text-slate-700"
                               placeholder="••••••••">
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <div class="flex items-center px-4">
                        <label for="remember_me" class="inline-flex items-center cursor-pointer">
                            <input id="remember_me" type="checkbox" class="rounded-lg border-slate-200 text-orange-600 shadow-sm focus:ring-orange-500 w-5 h-5" name="remember">
                            <span class="ms-3 text-sm font-bold text-slate-500 italic">Se souvenir de moi</span>
                        </label>
                    </div>

                    <div class="pt-4">
                        <button type="submit" class="w-full bg-orange-600 hover:bg-orange-700 text-white px-6 sm:px-8 py-4 sm:py-5 rounded-2xl font-black text-sm sm:text-base uppercase tracking-widest shadow-lg shadow-orange-200 transition-all hover:-translate-y-1 active:scale-95">
                            Se connecter
                        </button>
                    </div>
                </form>
            </div>

            <p class="text-center mt-8 text-slate-400 text-sm font-medium">
                Pas encore de compte ? 
                <a href="{{ route('register') }}" class="text-orange-500 font-black hover:underline">Devenir Vendeur</a>
            </p>
        </div>
    </div>
</x-guest-layout>
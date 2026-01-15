<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-[#FAFAFA] p-6">
        <div class="w-full max-w-2xl"> <div class="text-center mb-10">
                <div class="text-4xl font-black bg-gradient-to-r from-orange-600 to-orange-400 bg-clip-text text-transparent italic tracking-tighter mb-2">
                    FoodConnect.ci
                </div>
                <h1 class="text-2xl font-black text-slate-800 uppercase tracking-tighter">Rejoignez l'aventure</h1>
                <p class="text-slate-500 font-medium">Créez votre boutique et commencez à vendre en quelques clics.</p>
            </div>

            <div class="bg-white rounded-[3rem] shadow-xl shadow-orange-100/50 border border-orange-50 p-10 md:p-12">
                
                <form method="POST" action="{{ route('register') }}" class="space-y-6">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label for="name" class="text-[10px] font-black uppercase text-slate-400 ml-4 tracking-widest">Nom de la boutique</label>
                            <input id="name" type="text" name="name" :value="old('name')" required autofocus 
                                   class="w-full px-6 py-4 rounded-2xl bg-slate-50 border-none focus:ring-2 focus:ring-orange-500 transition-all placeholder:text-slate-300 font-bold text-slate-700 shadow-inner"
                                   placeholder="Ex: Le Délice Ivoirien">
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <div class="space-y-2">
                            <label for="email" class="text-[10px] font-black uppercase text-slate-400 ml-4 tracking-widest">Email professionnel</label>
                            <input id="email" type="email" name="email" :value="old('email')" required 
                                   class="w-full px-6 py-4 rounded-2xl bg-slate-50 border-none focus:ring-2 focus:ring-orange-500 transition-all placeholder:text-slate-300 font-bold text-slate-700 shadow-inner"
                                   placeholder="contact@boutique.ci">
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>
                    </div>

                    <div class="h-px bg-slate-100 w-full my-2"></div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label for="password" class="text-[10px] font-black uppercase text-slate-400 ml-4 tracking-widest">Mot de passe</label>
                            <input id="password" type="password" name="password" required autocomplete="new-password"
                                   class="w-full px-6 py-4 rounded-2xl bg-slate-50 border-none focus:ring-2 focus:ring-orange-500 transition-all placeholder:text-slate-300 font-bold text-slate-700 shadow-inner"
                                   placeholder="••••••••">
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        <div class="space-y-2">
                            <label for="password_confirmation" class="text-[10px] font-black uppercase text-slate-400 ml-4 tracking-widest">Confirmation</label>
                            <input id="password_confirmation" type="password" name="password_confirmation" required
                                   class="w-full px-6 py-4 rounded-2xl bg-slate-50 border-none focus:ring-2 focus:ring-orange-500 transition-all placeholder:text-slate-300 font-bold text-slate-700 shadow-inner"
                                   placeholder="••••••••">
                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                        </div>
                    </div>

                    <div class="pt-6">
                        <button type="submit" class="w-full bg-gradient-to-r from-orange-600 to-orange-500 hover:from-orange-700 hover:to-orange-600 text-white px-8 py-5 rounded-2xl font-black  uppercase tracking-[0.2em] shadow-lg shadow-orange-200 transition-all hover:-translate-y-1 active:scale-95 text-center">
                            Créer 
                        </button>
                    </div>

                    <div class="text-center pt-4">
                        <a class="text-xs font-bold text-slate-400 hover:text-orange-500 uppercase tracking-tighter transition-colors" href="{{ route('login') }}">
                            Déjà inscrit ? <span class="text-orange-600 underline underline-offset-4">Connectez-vous</span>
                        </a>
                    </div>
                </form>
            </div>

            <p class="text-center mt-8 text-slate-400 text-[10px] uppercase font-bold tracking-widest px-10">
                En vous inscrivant, vous rejoignez la plus grande communauté de restaurateurs de proximité.
            </p>
        </div>
    </div>
</x-guest-layout>
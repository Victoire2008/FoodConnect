
<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Informations du Profil') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Mettez à jour vos informations personnelles.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('vendeur.profile.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
    @csrf
    @method('put')

    {{-- NOM --}}
    <div>
        <x-input-label for="nom" :value="__('Nom')" />
        <x-text-input id="nom" name="nom" type="text" class="mt-1 block w-full"
            :value="old('nom', $user->nom)" autocomplete="nom" />
        <x-input-error class="mt-2" :messages="$errors->get('nom')" />
    </div>
    
        {{-- EMAIL --}}
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full"
                :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-2">
                    <p class="text-sm text-gray-800 dark:text-gray-200">
                        {{ __('Votre adresse email n’est pas vérifiée.') }}

                        <button form="send-verification"
                            class="underline text-sm text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-100 focus:outline-none">
                            {{ __('Cliquez ici pour renvoyer l’email de vérification.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                            {{ __('Un nouveau lien de vérification a été envoyé.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        {{-- PHOTO DE PROFIL --}}
        <div>
            <x-input-label for="photo" :value="__('Photo de profil')" />
            <input id="photo" name="photo" type="file" class="mt-1 block w-full" />

            @if ($user->photo)
                <img src="{{ asset('storage/' . $user->photo) }}" class="mt-2 h-20 w-20 rounded-full object-cover">
            @endif

            <x-input-error class="mt-2" :messages="$errors->get('photo')" />
        </div>

        {{-- WHATSAPP --}}
        
   <div>
    <x-input-label for="phone" :value="__('Numéro WhatsApp')" />
    {{-- On change id, name et le value --}}
    <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full"
        :value="old('phone', $user->phone)" autocomplete="phone" />
    <x-input-error class="mt-2" :messages="$errors->get('phone')" />
   </div>

        {{-- VILLE --}}
        <div>
            <x-input-label for="ville_id" :value="__('Ville')" />
            <select id="ville_id" name="ville_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                <option value="">Sélectionnez une ville</option>
                @foreach($villes as $ville)
                    <option value="{{ $ville->id }}" {{ old('ville_id', $user->ville_id) == $ville->id ? 'selected' : '' }}>
                        {{ $ville->name }}
                    </option>
                @endforeach
            </select>
            <x-input-error class="mt-2" :messages="$errors->get('ville_id')" />
        </div>

        {{-- COMMUNE --}}
        <div>
            <x-input-label for="commune_id" :value="__('Commune')" />
            <select id="commune_id" name="commune_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                <option value="">Sélectionnez une commune</option>
                @foreach($communes as $commune)
                    <option value="{{ $commune->id }}" {{ old('commune_id', $user->commune_id) == $commune->id ? 'selected' : '' }}>
                        {{ $commune->name }}
                    </option>
                @endforeach
            </select>
            <x-input-error class="mt-2" :messages="$errors->get('commune_id')" />
        </div>

        {{-- BIO --}}
        <div>
            <x-input-label for="bio" :value="__('Biographie')" />
            <textarea id="bio" name="bio" rows="4" class="mt-1 block w-full">{{ old('bio', $user->bio) }}</textarea>
            <x-input-error class="mt-2" :messages="$errors->get('bio')" />
        </div>

        {{-- SUBMIT --}}
        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Enregistrer') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400">
                    {{ __('Modifications enregistrées.') }}
                </p>
            @endif
        </div>
    </form>
</section>

<section>
    <header>
        <h2 class="text-lg font-bold text-slate-900 dark:text-slate-100">Informacion del perfil</h2>
        <p class="mt-1 text-sm text-slate-500">Actualiza tu nombre y correo de acceso.</p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="mt-6 space-y-5">
        @csrf
        @method('patch')

        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4 dark:border-slate-800 dark:bg-slate-950">
            <label for="profile_photo" class="mb-3 block text-sm font-medium text-slate-700 dark:text-slate-200">Foto de perfil</label>
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center">
                <img src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}" class="h-24 w-24 rounded-2xl border-4 border-white object-cover object-top shadow-md dark:border-slate-800">
                <div class="flex-1">
                    <input
                        id="profile_photo"
                        name="profile_photo"
                        type="file"
                        accept="image/png,image/jpeg,image/webp"
                        class="block w-full rounded-xl border border-slate-300 bg-white text-sm text-slate-700 file:mr-4 file:border-0 file:bg-emerald-800 file:px-4 file:py-2.5 file:text-sm file:font-semibold file:text-white hover:file:bg-emerald-900 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-200"
                    >
                    <p class="mt-2 text-xs text-slate-500">Formatos permitidos: JPG, PNG o WEBP. Maximo 2 MB.</p>
                    <x-input-error class="mt-2" :messages="$errors->get('profile_photo')" />
                </div>
            </div>
        </div>

        <div>
            <label for="name" class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-200">Nombre</label>
            <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name" class="block w-full rounded-xl border-slate-300 text-sm shadow-sm focus:border-emerald-600 focus:ring-emerald-600 dark:border-slate-700 dark:bg-slate-950 dark:text-slate-100">
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <label for="email" class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-200">Correo electronico</label>
            <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required autocomplete="username" class="block w-full rounded-xl border-slate-300 text-sm shadow-sm focus:border-emerald-600 focus:ring-emerald-600 dark:border-slate-700 dark:bg-slate-950 dark:text-slate-100">
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-3 rounded-xl bg-amber-50 p-3 text-sm text-amber-800">
                    Tu correo no esta verificado.
                    <button form="send-verification" class="font-semibold underline">Reenviar verificacion</button>
                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-emerald-700">Se envio un nuevo enlace de verificacion.</p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <button class="rounded-xl bg-emerald-800 px-5 py-2.5 text-sm font-bold text-white shadow-sm hover:bg-emerald-900">Guardar cambios</button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm font-medium text-emerald-700">Guardado.</p>
            @endif
        </div>
    </form>
</section>

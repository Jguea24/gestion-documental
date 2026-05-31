<section>
    <header>
        <h2 class="text-lg font-bold text-slate-900 dark:text-slate-100">Seguridad</h2>
        <p class="mt-1 text-sm text-slate-500">Usa una contrasena segura para proteger tu cuenta.</p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-5">
        @csrf
        @method('put')

        <div>
            <label for="update_password_current_password" class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-200">Contrasena actual</label>
            <input id="update_password_current_password" name="current_password" type="password" autocomplete="current-password" class="block w-full rounded-xl border-slate-300 text-sm shadow-sm focus:border-emerald-600 focus:ring-emerald-600 dark:border-slate-700 dark:bg-slate-950 dark:text-slate-100">
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <div>
            <label for="update_password_password" class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-200">Nueva contrasena</label>
            <input id="update_password_password" name="password" type="password" autocomplete="new-password" class="block w-full rounded-xl border-slate-300 text-sm shadow-sm focus:border-emerald-600 focus:ring-emerald-600 dark:border-slate-700 dark:bg-slate-950 dark:text-slate-100">
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        <div>
            <label for="update_password_password_confirmation" class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-200">Confirmar contrasena</label>
            <input id="update_password_password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" class="block w-full rounded-xl border-slate-300 text-sm shadow-sm focus:border-emerald-600 focus:ring-emerald-600 dark:border-slate-700 dark:bg-slate-950 dark:text-slate-100">
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4">
            <button class="rounded-xl bg-emerald-800 px-5 py-2.5 text-sm font-bold text-white shadow-sm hover:bg-emerald-900">Actualizar contrasena</button>

            @if (session('status') === 'password-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm font-medium text-emerald-700">Actualizada.</p>
            @endif
        </div>
    </form>
</section>

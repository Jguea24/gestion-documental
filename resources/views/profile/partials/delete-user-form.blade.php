<section class="space-y-5">
    <header>
        <h2 class="text-lg font-bold text-red-700 dark:text-red-300">Eliminar cuenta</h2>
        <p class="mt-1 max-w-3xl text-sm text-slate-500">
            Esta accion elimina permanentemente tu cuenta. Antes de continuar, verifica que no necesites conservar informacion asociada.
        </p>
    </header>

    <button
        type="button"
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="rounded-xl border border-red-200 px-5 py-2.5 text-sm font-bold text-red-700 hover:bg-red-50 dark:border-red-900 dark:text-red-300 dark:hover:bg-red-950"
    >
        Eliminar mi cuenta
    </button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="text-lg font-bold text-slate-900">Confirmar eliminacion</h2>
            <p class="mt-2 text-sm text-slate-600">Ingresa tu contrasena para eliminar permanentemente la cuenta.</p>

            <div class="mt-6">
                <label for="password" class="sr-only">Contrasena</label>
                <input id="password" name="password" type="password" class="block w-full rounded-xl border-slate-300 text-sm shadow-sm focus:border-red-500 focus:ring-red-500" placeholder="Contrasena">
                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <button type="button" x-on:click="$dispatch('close')" class="rounded-xl border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">Cancelar</button>
                <button class="rounded-xl bg-red-600 px-4 py-2 text-sm font-bold text-white hover:bg-red-700">Eliminar cuenta</button>
            </div>
        </form>
    </x-modal>
</section>

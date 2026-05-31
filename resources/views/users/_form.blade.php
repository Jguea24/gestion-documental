@csrf

<div class="grid gap-6 lg:grid-cols-[1fr_1.1fr]">
    <section class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
        <h2 class="text-lg font-semibold text-slate-900 dark:text-slate-100">Datos del usuario</h2>
        <p class="mt-1 text-sm text-slate-500">Define la cuenta de acceso al sistema.</p>

        <div class="mt-6 space-y-5">
            <div>
                <label for="name" class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-200">Nombre</label>
                <input id="name" name="name" value="{{ old('name', $user->name) }}" required class="block w-full rounded-lg border-slate-300 text-sm shadow-sm focus:border-emerald-600 focus:ring-emerald-600 dark:border-slate-700 dark:bg-slate-950 dark:text-slate-100">
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <div>
                <label for="email" class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-200">Correo</label>
                <input id="email" type="email" name="email" value="{{ old('email', $user->email) }}" required class="block w-full rounded-lg border-slate-300 text-sm shadow-sm focus:border-emerald-600 focus:ring-emerald-600 dark:border-slate-700 dark:bg-slate-950 dark:text-slate-100">
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div>
                <label for="password" class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-200">
                    Contrasena {{ $user->exists ? '(dejar vacio para mantener)' : '' }}
                </label>
                <input id="password" type="password" name="password" {{ $user->exists ? '' : 'required' }} class="block w-full rounded-lg border-slate-300 text-sm shadow-sm focus:border-emerald-600 focus:ring-emerald-600 dark:border-slate-700 dark:bg-slate-950 dark:text-slate-100">
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div>
                <label for="password_confirmation" class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-200">Confirmar contrasena</label>
                <input id="password_confirmation" type="password" name="password_confirmation" {{ $user->exists ? '' : 'required' }} class="block w-full rounded-lg border-slate-300 text-sm shadow-sm focus:border-emerald-600 focus:ring-emerald-600 dark:border-slate-700 dark:bg-slate-950 dark:text-slate-100">
            </div>
        </div>
    </section>

    <section class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
        <h2 class="text-lg font-semibold text-slate-900 dark:text-slate-100">Roles y permisos</h2>
        <p class="mt-1 text-sm text-slate-500">El rol define el acceso base. Los permisos directos agregan excepciones puntuales.</p>

        @php
            $selectedRoles = old('roles', $user->roles->pluck('name')->all());
            $selectedPermissions = old('permissions', $user->permissions->pluck('name')->all());
        @endphp

        <div class="mt-6">
            <h3 class="mb-3 text-sm font-semibold uppercase tracking-wide text-slate-500">Roles</h3>
            <div class="grid gap-2 sm:grid-cols-3">
                @foreach ($roles as $role)
                    <label class="flex items-center gap-2 rounded-xl border border-slate-200 px-3 py-2 text-sm dark:border-slate-700">
                        <input type="checkbox" name="roles[]" value="{{ $role->name }}" @checked(in_array($role->name, $selectedRoles, true)) class="rounded border-slate-300 text-emerald-700 focus:ring-emerald-600">
                        <span class="font-medium text-slate-700 dark:text-slate-200">{{ $role->name }}</span>
                    </label>
                @endforeach
            </div>
            <x-input-error :messages="$errors->get('roles')" class="mt-2" />
        </div>

        <div class="mt-8">
            <h3 class="mb-3 text-sm font-semibold uppercase tracking-wide text-slate-500">Permisos directos</h3>
            <div class="max-h-[28rem] space-y-4 overflow-y-auto pr-2">
                @foreach ($permissionsByGroup as $group => $permissions)
                    <div class="rounded-xl border border-slate-200 p-4 dark:border-slate-700">
                        <h4 class="mb-3 text-sm font-semibold text-slate-800 dark:text-slate-100">{{ ucfirst($group) }}</h4>
                        <div class="grid gap-2 sm:grid-cols-2">
                            @foreach ($permissions as $permission)
                                <label class="flex items-center gap-2 text-sm text-slate-600 dark:text-slate-300">
                                    <input type="checkbox" name="permissions[]" value="{{ $permission->name }}" @checked(in_array($permission->name, $selectedPermissions, true)) class="rounded border-slate-300 text-emerald-700 focus:ring-emerald-600">
                                    <span>{{ $permission->name }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
            <x-input-error :messages="$errors->get('permissions')" class="mt-2" />
        </div>
    </section>
</div>

<div class="mt-6 flex justify-end gap-3">
    <a href="{{ route('users.index') }}" class="rounded-lg border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-white dark:border-slate-700 dark:text-slate-200 dark:hover:bg-slate-900">Cancelar</a>
    <button class="rounded-lg bg-emerald-800 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-900">Guardar usuario</button>
</div>

<x-app-layout>
    <div class="min-h-[calc(100vh-4rem)] bg-slate-50 p-4 dark:bg-slate-950 lg:p-6">
        <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-slate-900 dark:text-slate-100">Usuarios</h1>
                <p class="text-sm text-slate-500">Administra cuentas, roles y permisos del sistema.</p>
            </div>
            @can('users.create')
                <a href="{{ route('users.create') }}" class="inline-flex rounded-lg bg-emerald-800 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-900">Nuevo usuario</a>
            @endcan
        </div>

        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200 dark:divide-slate-800">
                    <thead class="bg-slate-100 text-left text-xs font-semibold uppercase tracking-wide text-slate-500 dark:bg-slate-800 dark:text-slate-300">
                        <tr>
                            <th class="px-4 py-3">Usuario</th>
                            <th class="px-4 py-3">Roles</th>
                            <th class="px-4 py-3">Permisos directos</th>
                            <th class="px-4 py-3 text-right">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                        @forelse ($users as $user)
                            <tr class="text-sm">
                                <td class="px-4 py-4">
                                    <div class="font-semibold text-slate-900 dark:text-slate-100">{{ $user->name }}</div>
                                    <div class="text-slate-500">{{ $user->email }}</div>
                                </td>
                                <td class="px-4 py-4">
                                    <div class="flex flex-wrap gap-1">
                                        @forelse ($user->roles as $role)
                                            <span class="rounded-full bg-emerald-100 px-2 py-1 text-xs font-semibold text-emerald-800 dark:bg-emerald-950 dark:text-emerald-200">{{ $role->name }}</span>
                                        @empty
                                            <span class="text-slate-400">Sin rol</span>
                                        @endforelse
                                    </div>
                                </td>
                                <td class="px-4 py-4 text-slate-600 dark:text-slate-300">{{ $user->permissions->count() }}</td>
                                <td class="px-4 py-4 text-right">
                                    <div class="flex justify-end gap-2">
                                        @can('users.edit')
                                            <a href="{{ route('users.edit', $user) }}" class="rounded-lg border border-slate-300 px-3 py-1.5 text-xs font-semibold text-slate-700 hover:bg-slate-50 dark:border-slate-700 dark:text-slate-200 dark:hover:bg-slate-800">Editar</a>
                                        @endcan
                                        @can('users.delete')
                                            @if (auth()->id() !== $user->id)
                                                <form method="POST" action="{{ route('users.destroy', $user) }}" onsubmit="return confirmSubmit(this, 'Eliminar usuario', 'Esta accion eliminara el usuario seleccionado.')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="rounded-lg border border-red-200 px-3 py-1.5 text-xs font-semibold text-red-600 hover:bg-red-50 dark:border-red-900 dark:hover:bg-red-950">Eliminar</button>
                                                </form>
                                            @endif
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-4 py-10 text-center text-sm text-slate-500">No hay usuarios registrados.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-4">{{ $users->links() }}</div>
    </div>
</x-app-layout>

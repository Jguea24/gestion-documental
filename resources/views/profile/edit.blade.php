<x-app-layout>
    <div class="min-h-[calc(100vh-4rem)] bg-slate-100 p-4 dark:bg-slate-950 lg:p-6">
        <div class="mx-auto max-w-6xl space-y-6">
            <section class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">
                <div class="bg-gradient-to-br from-emerald-900 to-emerald-700 px-6 py-8 text-white sm:px-8">
                    <div class="flex flex-col gap-5 sm:flex-row sm:items-center sm:justify-between">
                        <div class="flex items-center gap-4">
                            <img src="{{ auth()->user()->profile_photo_url }}" alt="{{ auth()->user()->name }}" class="h-20 w-20 rounded-2xl border-4 border-white/70 object-cover object-top shadow-lg">
                            <div>
                                <p class="text-sm font-medium uppercase tracking-[0.25em] text-emerald-100">Mi cuenta</p>
                                <h1 class="mt-1 text-3xl font-bold">{{ auth()->user()->name }}</h1>
                                <p class="mt-1 text-sm text-emerald-50">{{ auth()->user()->email }}</p>
                            </div>
                        </div>
                        <div class="rounded-2xl bg-white/10 px-4 py-3 text-sm ring-1 ring-white/20">
                            <div class="text-emerald-100">Rol principal</div>
                            <div class="mt-1 font-semibold">{{ auth()->user()->roles->pluck('name')->first() ?? 'Sin rol' }}</div>
                        </div>
                    </div>
                </div>
            </section>

            <div class="grid gap-6 xl:grid-cols-[1fr_1fr]">
                <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                    @include('profile.partials.update-profile-information-form')
                </div>

                <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="rounded-3xl border border-red-100 bg-white p-6 shadow-sm dark:border-red-950 dark:bg-slate-900">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
</x-app-layout>

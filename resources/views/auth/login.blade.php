<x-guest-layout plain>
    <main
        x-data="{ showPassword: false }"
        class="relative flex min-h-screen flex-col overflow-y-auto bg-slate-100 text-slate-900"
    >
        <div class="absolute inset-0 bg-[linear-gradient(60deg,rgba(148,163,184,.18)_0_18%,transparent_18%_32%,rgba(203,213,225,.45)_32%_48%,transparent_48%_62%,rgba(148,163,184,.30)_62%_78%,transparent_78%)]"></div>
        <div class="absolute inset-x-0 top-0 h-24 bg-gradient-to-b from-white/70 to-transparent"></div>

        <section class="relative z-10 flex flex-1 items-center justify-center px-4 py-5 sm:py-8 lg:py-10">
            <div class="grid w-full max-w-md overflow-hidden rounded-2xl bg-white shadow-2xl shadow-slate-500/30 md:max-w-5xl md:grid-cols-[0.85fr_1.55fr]">
                <aside class="hidden min-h-[30rem] flex-col items-center justify-center bg-emerald-900 px-8 py-10 text-center text-white md:flex">
                    <div class="mb-8 rounded-full bg-white/10 p-2 shadow-2xl shadow-emerald-950/40 ring-1 ring-white/25">
                        <img
                            src="{{ asset('images/johnny.png') }}"
                            alt="Johnny Grefa"
                            class="h-40 w-40 rounded-full border-4 border-white/90 object-cover object-top shadow-lg"
                        >
                    </div>
                    <h1 class="text-2xl font-semibold leading-tight">Sistema de Gestion <br>Documental</h1>
                    <p class="mt-3 text-base text-emerald-50">Johnny Grefa</p>
                </aside>

                <div class="flex items-center justify-center px-5 py-6 sm:px-10 sm:py-9 lg:px-16">
                    <div class="w-full max-w-sm">
                        <div class="mb-5 md:hidden">
                            <img
                                src="{{ asset('images/johnny.png') }}"
                                alt="Johnny Grefa"
                                class="mx-auto h-24 w-24 rounded-full border-4 border-emerald-100 object-cover object-top shadow-lg shadow-slate-300/60"
                            >
                            <h1 class="mt-2 text-center text-lg font-semibold text-slate-800">Sistema de Gestion Documental</h1>
                            <p class="mt-1 text-center text-xs font-medium text-slate-500">Wini S.A.S</p>
                        </div>

                        <x-auth-session-status class="mb-4 rounded-lg bg-emerald-50 px-4 py-3 text-sm text-emerald-700" :status="session('status')" />

                        <form method="POST" action="{{ route('login') }}" class="space-y-4 sm:space-y-6">
                            @csrf

                            <div>
                                <label for="email" class="sr-only">Usuario</label>
                                <input
                                    id="email"
                                    type="email"
                                    name="email"
                                    value="{{ old('email') }}"
                                    required
                                    autofocus
                                    autocomplete="username"
                                    placeholder="Usuario"
                                    class="block w-full rounded-lg border border-slate-200 bg-white px-4 py-2.5 text-sm text-slate-700 shadow-sm placeholder:text-slate-500 focus:border-emerald-600 focus:ring-emerald-600 sm:py-3"
                                >
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>

                            <div>
                                <label for="password" class="sr-only">Contrasena</label>
                                <div class="relative">
                                    <input
                                        id="password"
                                        :type="showPassword ? 'text' : 'password'"
                                        name="password"
                                        required
                                        autocomplete="current-password"
                                        placeholder="Contrasena"
                                        class="block w-full rounded-lg border border-slate-200 bg-white px-4 py-2.5 pr-12 text-sm text-slate-700 shadow-sm placeholder:text-slate-500 focus:border-emerald-600 focus:ring-emerald-600 sm:py-3"
                                    >
                                    <button
                                        type="button"
                                        @click="showPassword = !showPassword"
                                        class="absolute inset-y-0 right-3 flex items-center text-slate-400 hover:text-slate-700"
                                        aria-label="Mostrar u ocultar contrasena"
                                    >
                                        <svg x-show="!showPassword" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7-10-7-10-7z" />
                                            <circle cx="12" cy="12" r="3" />
                                        </svg>
                                        <svg x-show="showPassword" x-cloak class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M3 3l18 18" />
                                            <path d="M10.6 10.6A2 2 0 0012 14a2 2 0 001.4-.6" />
                                            <path d="M9.9 5.2A9.5 9.5 0 0112 5c6.5 0 10 7 10 7a17.5 17.5 0 01-2.6 3.6" />
                                            <path d="M6.6 6.6C3.6 8.7 2 12 2 12s3.5 7 10 7a9.5 9.5 0 004.2-.9" />
                                        </svg>
                                    </button>
                                </div>
                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            </div>

                            <div>
                                <label for="institution" class="mb-1 block pl-3 text-[11px] text-slate-500">Institucion</label>
                                <select
                                    id="institution"
                                    class="block w-full rounded-lg border border-slate-200 bg-white px-4 py-2.5 text-sm text-slate-700 shadow-sm focus:border-emerald-600 focus:ring-emerald-600 sm:py-3"
                                >
                                    <option>Wini S.A.S</option>
                                </select>
                            </div>

                            <label for="remember_me" class="flex items-center text-sm text-slate-600">
                                <input id="remember_me" type="checkbox" class="rounded border-slate-300 text-slate-700 shadow-sm focus:ring-slate-500" name="remember">
                                <span class="ms-2">Recordar sesion</span>
                            </label>

                            <button
                                type="submit"
                                class="w-full rounded-xl bg-emerald-800 px-5 py-3 text-center text-sm font-bold text-white shadow-lg shadow-emerald-600/30 transition hover:bg-emerald-900 focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:ring-offset-2 sm:py-3.5 sm:text-base"
                            >
                                Iniciar Sesion
                            </button>

                            @if (Route::has('password.request'))
                                <div class="text-center">
                                    <a class="text-sm text-slate-700 hover:text-slate-950 hover:underline" href="{{ route('password.request') }}">
                                        Olvidaste tu contrasena?
                                    </a>
                                </div>
                            @endif
                        </form>

                        <div class="mt-6 text-center text-xs text-slate-500 sm:mt-10 sm:text-sm md:text-left">
                            Politica de Privacidad
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <footer class="relative z-10 bg-lime-400 py-2 text-center text-xs font-semibold text-slate-800">
            Copyright © Wini S.A.S {{ now()->year }}
        </footer>
    </main>
</x-guest-layout>

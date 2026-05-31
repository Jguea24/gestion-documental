<x-guest-layout plain>
    <main class="relative flex min-h-screen flex-col overflow-hidden bg-slate-100 text-slate-900">
        <div class="absolute inset-0 bg-[linear-gradient(60deg,rgba(16,185,129,.10)_0_18%,transparent_18%_32%,rgba(203,213,225,.45)_32%_48%,transparent_48%_62%,rgba(16,185,129,.16)_62%_78%,transparent_78%)]"></div>
        <div class="absolute inset-x-0 top-0 h-24 bg-gradient-to-b from-white/70 to-transparent"></div>

        <section class="relative z-10 flex flex-1 items-center justify-center px-4 py-10">
            <div class="grid w-full max-w-5xl overflow-hidden rounded-2xl bg-white shadow-2xl shadow-slate-500/30 md:grid-cols-[0.85fr_1.55fr]">
                <aside class="flex min-h-[30rem] flex-col items-center justify-center bg-emerald-900 px-8 py-10 text-center text-white">
                    <img
                        src="{{ asset('images/logo.png') }}"
                        alt="Universidad Estatal Amazonica"
                        class="mb-8 h-36 w-36 object-contain drop-shadow"
                    >
                    <h1 class="text-2xl font-semibold leading-tight">Recuperar<br>Acceso</h1>
                    <p class="mt-3 text-base text-emerald-50">Sistema de Gestion Documental</p>
                </aside>

                <div class="flex items-center justify-center px-6 py-10 sm:px-10 lg:px-16">
                    <div class="w-full max-w-sm">
                        <div class="mb-8 md:hidden">
                            <img src="{{ asset('images/logo.png') }}" alt="Universidad Estatal Amazonica" class="mx-auto h-24 w-24 object-contain">
                            <h1 class="mt-3 text-center text-xl font-semibold text-slate-800">Recuperar acceso</h1>
                        </div>

                        <div class="mb-8">
                            <h2 class="text-2xl font-bold text-slate-800">Olvidaste tu contrasena?</h2>
                            <p class="mt-3 text-sm leading-6 text-slate-500">
                                Ingresa tu correo institucional y te enviaremos un enlace para restablecer tu contrasena.
                            </p>
                        </div>

                        <x-auth-session-status class="mb-4 rounded-lg bg-emerald-50 px-4 py-3 text-sm text-emerald-700" :status="session('status')" />

                        <form method="POST" action="{{ route('password.email') }}" class="space-y-7">
                            @csrf

                            <div>
                                <label for="email" class="sr-only">Correo electronico</label>
                                <input
                                    id="email"
                                    type="email"
                                    name="email"
                                    value="{{ old('email') }}"
                                    required
                                    autofocus
                                    placeholder="Correo electronico"
                                    class="block w-full rounded-lg border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700 shadow-sm placeholder:text-slate-500 focus:border-emerald-600 focus:ring-emerald-600"
                                >
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>

                            <button
                                type="submit"
                                class="w-full rounded-xl bg-emerald-800 px-5 py-3.5 text-center text-sm font-bold uppercase tracking-wide text-white shadow-lg shadow-emerald-600/30 transition hover:bg-emerald-900 focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:ring-offset-2"
                            >
                                Enviar enlace de recuperacion
                            </button>

                            <div class="text-center">
                                <a href="{{ route('login') }}" class="text-sm font-medium text-slate-700 hover:text-emerald-800 hover:underline">
                                    Volver al inicio de sesion
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>

        <footer class="relative z-10 bg-lime-400 py-2 text-center text-xs font-semibold text-slate-800">
            Copyright © Universidad Estatal Amazonica {{ now()->year }}
        </footer>
    </main>
</x-guest-layout>

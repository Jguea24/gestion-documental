<nav x-data="{ open: false }" class="bg-white/95 border-b border-slate-200 shadow-sm backdrop-blur dark:bg-slate-950/95 dark:border-slate-800">
    <!-- Primary Navigation Menu -->
    <div class="px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('explorer.index') }}" class="flex items-center gap-3">
                        <img src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" class="h-10 w-10 rounded-xl object-cover object-top ring-2 ring-emerald-100">
                        <div class="hidden leading-tight lg:block">
                            <div class="text-sm font-bold text-slate-900 dark:text-slate-100">Wini S.A.S</div>
                            <div class="text-xs text-slate-500 dark:text-slate-400">{{ __('Document Management') }}</div>
                        </div>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    @if (Auth::user()->can('dashboard.ver') && ! Auth::user()->hasRestrictedFolderAccess())
                        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                            {{ __('Dashboard') }}
                        </x-nav-link>
                    @endif
                    <x-nav-link :href="route('explorer.index')" :active="request()->routeIs('explorer.*')">
                        {{ __('Explorer') }}
                    </x-nav-link>
                    <x-nav-link :href="route('trash.index')" :active="request()->routeIs('trash.*')">
                        {{ __('Trash') }}
                    </x-nav-link>
                    @can('users.view')
                        <x-nav-link :href="route('users.index')" :active="request()->routeIs('users.*')">
                            {{ __('Users') }}
                        </x-nav-link>
                    @endcan
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6 sm:gap-3">
                <div class="inline-flex overflow-hidden rounded-full border border-slate-200 bg-slate-50 text-xs font-bold dark:border-slate-800 dark:bg-slate-900">
                    <a href="{{ route('language.switch', 'es') }}" class="px-3 py-2 {{ app()->getLocale() === 'es' ? 'bg-blue-600 text-white' : 'text-slate-600 hover:bg-white dark:text-slate-300 dark:hover:bg-slate-800' }}">ES</a>
                    <a href="{{ route('language.switch', 'en') }}" class="px-3 py-2 {{ app()->getLocale() === 'en' ? 'bg-blue-600 text-white' : 'text-slate-600 hover:bg-white dark:text-slate-300 dark:hover:bg-slate-800' }}">EN</a>
                </div>

                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center rounded-full border border-slate-200 bg-slate-50 px-3 py-2 text-sm font-medium leading-4 text-slate-600 transition hover:bg-white hover:text-emerald-800 focus:outline-none dark:border-slate-800 dark:bg-slate-900 dark:text-slate-300">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            @if (Auth::user()->can('dashboard.ver') && ! Auth::user()->hasRestrictedFolderAccess())
                <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                    {{ __('Dashboard') }}
                </x-responsive-nav-link>
            @endif
            <x-responsive-nav-link :href="route('explorer.index')" :active="request()->routeIs('explorer.*')">
                {{ __('Explorer') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('trash.index')" :active="request()->routeIs('trash.*')">
                {{ __('Trash') }}
            </x-responsive-nav-link>
            @can('users.view')
                <x-responsive-nav-link :href="route('users.index')" :active="request()->routeIs('users.*')">
                    {{ __('Users') }}
                </x-responsive-nav-link>
            @endcan
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <div class="px-4 py-2">
                    <div class="mb-2 text-xs font-semibold uppercase text-slate-500">{{ __('Language') }}</div>
                    <div class="inline-flex overflow-hidden rounded-full border border-slate-200 bg-slate-50 text-xs font-bold">
                        <a href="{{ route('language.switch', 'es') }}" class="px-3 py-2 {{ app()->getLocale() === 'es' ? 'bg-blue-600 text-white' : 'text-slate-600' }}">ES</a>
                        <a href="{{ route('language.switch', 'en') }}" class="px-3 py-2 {{ app()->getLocale() === 'en' ? 'bg-blue-600 text-white' : 'text-slate-600' }}">EN</a>
                    </div>
                </div>

                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>

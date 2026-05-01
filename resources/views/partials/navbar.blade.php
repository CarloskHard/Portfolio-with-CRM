{{-- COMPONENTE DE NAVEGACIÓN PÚBLICA --}}
@php
    $currentRoute = Route::currentRouteName();
    $isHome = $currentRoute === 'home';
@endphp

<nav
    x-data="{ scrolled: false }"
    x-init="scrolled = window.scrollY > 20; window.addEventListener('scroll', () => { scrolled = window.scrollY > 20 })"
    class="fixed w-full z-50 top-0 start-0 px-3 md:px-5 pt-3 transition-all duration-300"
>
    <div class="w-full px-8 bg-white/38 dark:bg-[#0a0a0a]/46 backdrop-blur-3xl backdrop-saturate-150 border border-white/45 dark:border-white/[0.16] shadow-[0_8px_30px_rgba(0,0,0,0.08)] dark:shadow-[0_8px_30px_rgba(0,0,0,0.28)] rounded-[1.25rem] transition-all duration-300"
         :class="scrolled ? 'py-3 shadow-sm' : 'py-5'">
        <!-- Flex container: Logo | Nav links + Theme + CTA -->
        <div class="flex items-center justify-between">

            <!-- LOGO - Izquierda -->
            <a href="{{ route('home') }}"
               class="shrink-0 hover:opacity-70 transition-opacity duration-200"
               style="font-family: 'JetBrains Mono', 'Fira Code', ui-monospace, monospace; font-weight: 700; font-size: 19px; letter-spacing: 0.04em; text-decoration: none;">
                <span class="text-gray-900 dark:text-gray-50">CARLOS</span><span class="text-gray-400 dark:text-gray-600">.CODEX</span>
            </a>

            <!-- MENÚ DERECHA (desktop) + Controles -->
            <div x-data="{ open: false }" @click.outside="open = false" class="flex items-center gap-6">

                <!-- DESKTOP: Nav links -->
                <ul class="hidden md:flex items-center gap-8"
                    style="font-family: 'Geist', 'Inter', system-ui, sans-serif; font-size: 16px; font-weight: 500; list-style: none; margin: 0; padding: 0;">
                    <li>
                        <a href="{{ route('public.about') }}"
                           @click="open = false"
                           class="text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white transition-colors duration-200"
                           style="text-decoration: none;">
                           Sobre mí
                        </a>
                    </li>
                    <li>
                        <a href="{{ $isHome ? '#projects' : route('home') . '#projects' }}"
                           @click="open = false"
                           class="text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white transition-colors duration-200"
                           style="text-decoration: none;">
                           Proyectos
                        </a>
                    </li>
                    <li>
                        <a href="{{ $isHome ? '#skills' : route('home') . '#skills' }}"
                           @click="open = false"
                           class="text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white transition-colors duration-200"
                           style="text-decoration: none;">
                           Habilidades
                        </a>
                    </li>
                </ul>

                <!-- SEPARADOR visual (desktop) -->
                <!--<div class="hidden md:block w-px h-5 bg-black/10 dark:bg-white/10"></div>-->

                <!-- THEME TOGGLE -->
                <x-theme-toggle />

                <!-- HABLEMOS CTA (desktop) -->
                <a href="{{ $isHome ? '#contact' : route('home') . '#contact' }}"
                   @click="open = false"
                   class="group hidden md:inline-flex items-center gap-2.5 border border-gray-900 dark:border-white/80 rounded-full text-gray-900 dark:text-white hover:bg-gray-900 dark:hover:bg-white hover:text-white dark:hover:text-gray-900 transition-all duration-[220ms] ease-[cubic-bezier(0.34,1.56,0.64,1)] hover:scale-[1.045]"
                   style="font-family: 'Geist', 'Inter', system-ui, sans-serif; font-size: 15px; font-weight: 500; padding: 8px 18px 8px 10px; text-decoration: none;">
                    <span class="w-[22px] h-[22px] rounded-full bg-gray-900 dark:bg-white text-white dark:text-gray-900 inline-flex items-center justify-center flex-shrink-0 group-hover:bg-white dark:group-hover:bg-gray-900 group-hover:text-gray-900 dark:group-hover:text-white transition-colors duration-200"
                          style="font-size: 12px;">→</span>
                    Hablemos
                </a>

                <!-- MOBILE BUTTON -->
                <button @click="open = !open" type="button"
                    class="md:hidden inline-flex items-center p-2 w-9 h-9 justify-center rounded-lg transition-colors"
                    :class="{
                        'bg-gray-900/10 dark:bg-white/10 text-gray-900 dark:text-white': open,
                        'text-gray-500 dark:text-gray-400': !open
                    }"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              x-show="!open" d="M4 6h16M4 12h16M4 18h16"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              x-show="open" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>

                <!-- MOBILE MENU (dropdown) -->
                <div x-show="open"
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 -translate-y-2"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     x-transition:leave="transition ease-in duration-150"
                     x-transition:leave-start="opacity-100 translate-y-0"
                     x-transition:leave-end="opacity-0 -translate-y-2"
                     class="md:hidden absolute top-full left-0 right-0 bg-white/50 dark:bg-[#0a0a0a]/58 backdrop-blur-3xl backdrop-saturate-150 border-b border-white/40 dark:border-white/[0.14] shadow-[0_10px_30px_rgba(0,0,0,0.1)] dark:shadow-[0_10px_30px_rgba(0,0,0,0.3)]"
                     style="display: none;">
                    <ul class="flex flex-col gap-0 py-2 px-6"
                        style="font-family: 'Geist', 'Inter', system-ui, sans-serif; font-size: 16px; font-weight: 500; list-style: none; margin: 0; padding-top: 12px; padding-bottom: 16px;">
                        <li>
                            <a href="{{ route('public.about') }}"
                               @click="open = false"
                               class="block py-2.5 text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white transition-colors duration-200"
                               style="text-decoration: none;">
                               Sobre mí
                            </a>
                        </li>
                        <li>
                            <a href="{{ $isHome ? '#projects' : route('home') . '#projects' }}"
                               @click="open = false"
                               class="block py-2.5 text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white transition-colors duration-200"
                               style="text-decoration: none;">
                               Proyectos
                            </a>
                        </li>
                        <li>
                            <a href="{{ $isHome ? '#skills' : route('home') . '#skills' }}"
                               @click="open = false"
                               class="block py-2.5 text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white transition-colors duration-200"
                               style="text-decoration: none;">
                               Habilidades
                            </a>
                        </li>
                        <li class="pt-3 pb-1">
                            <a href="{{ $isHome ? '#contact' : route('home') . '#contact' }}"
                               @click="open = false"
                               class="group inline-flex items-center gap-2.5 border border-gray-900 dark:border-white/80 rounded-full text-gray-900 dark:text-white hover:bg-gray-900 dark:hover:bg-white hover:text-white dark:hover:text-gray-900 transition-all duration-[220ms] ease-[cubic-bezier(0.34,1.56,0.64,1)] hover:scale-[1.045]"
                               style="font-size: 15px; font-weight: 500; padding: 8px 18px 8px 10px; text-decoration: none;">
                                <span class="w-[22px] h-[22px] rounded-full bg-gray-900 dark:bg-white text-white dark:text-gray-900 inline-flex items-center justify-center flex-shrink-0 group-hover:bg-white dark:group-hover:bg-gray-900 group-hover:text-gray-900 dark:group-hover:text-white transition-colors duration-200"
                                      style="font-size: 12px;">→</span>
                                Hablemos
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</nav>
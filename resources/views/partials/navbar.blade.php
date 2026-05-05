{{-- COMPONENTE DE NAVEGACIÓN PÚBLICA --}}
@php
    $currentRoute = Route::currentRouteName();
    $isHome = $currentRoute === 'home';
    $isAbout = $currentRoute === 'public.about';
    $isProjectsListing = $currentRoute === 'public.projects';

    $navInactive = 'border-l-transparent text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white';
    $navActive = 'border-l-indigo-600 dark:border-l-indigo-400 text-gray-900 dark:text-white';
    $navInactiveDesktop = 'border-b-2 border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white';
    $navActiveDesktop = 'border-b-2 border-indigo-600 dark:border-indigo-400 text-gray-900 dark:text-white';
    $navInactiveMobile = 'border-l-transparent text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white bg-transparent';
    $navActiveMobile = 'border-l-indigo-600 dark:border-l-indigo-400 text-gray-900 dark:text-white bg-gray-100/80 dark:bg-white/5';
@endphp

<nav
    x-data="{
        scrolled: typeof window !== 'undefined' && window.scrollY > 20,
        navTransitionEnabled: false,
        open: false,
        isHome: @json($isHome),
        isAboutPage: @json($isAbout),
        isProjectsPage: @json($isProjectsListing),
        activeHomeSection: null,
        navScrollActiveDesktop: '!border-b-indigo-600 dark:!border-b-indigo-400 !text-gray-900 dark:!text-white',
        navScrollActiveMobile: '!border-l-indigo-600 dark:!border-l-indigo-400 !text-gray-900 dark:!text-white !bg-gray-100/80 dark:!bg-white/5',
        init() {
            const syncScroll = () => {
                this.scrolled = window.scrollY > 20;
                this.updateHomeSection();
            };
            window.addEventListener('scroll', syncScroll, { passive: true });
            window.addEventListener('resize', syncScroll, { passive: true });
            syncScroll();
            requestAnimationFrame(() => {
                syncScroll();
                requestAnimationFrame(() => {
                    syncScroll();
                    this.navTransitionEnabled = true;
                });
            });
        },
        updateHomeSection() {
            if (!this.isHome) {
                this.activeHomeSection = null;
                return;
            }
            const skills = document.getElementById('skills');
            const projects = document.getElementById('projects');
            const contact = document.getElementById('contact');
            if (!skills || !projects || !contact) {
                this.activeHomeSection = null;
                return;
            }
            /* Punto de lectura: centro vertical del viewport (coordenadas de vista). */
            const refY = window.innerHeight * 0.5;
            const tracked = [
                { id: 'skills', el: skills },
                { id: 'projects', el: projects },
                { id: 'contact', el: contact },
            ];
            for (let i = 0; i < tracked.length; i++) {
                const r = tracked[i].el.getBoundingClientRect();
                if (refY >= r.top && refY <= r.bottom) {
                    this.activeHomeSection = tracked[i].id;
                    return;
                }
            }
            const skillsR = skills.getBoundingClientRect();
            const contactR = contact.getBoundingClientRect();
            if (refY < skillsR.top) {
                this.activeHomeSection = null;
                return;
            }
            if (refY > contactR.bottom) {
                this.activeHomeSection = 'contact';
                return;
            }
            let bestId = 'skills';
            let bestDist = Infinity;
            for (let j = 0; j < tracked.length; j++) {
                const r = tracked[j].el.getBoundingClientRect();
                let d = 0;
                if (refY < r.top) d = r.top - refY;
                else if (refY > r.bottom) d = refY - r.bottom;
                if (d < bestDist) {
                    bestDist = d;
                    bestId = tracked[j].id;
                }
            }
            this.activeHomeSection = bestId;
        },
    }"
    class="fixed w-full z-50 top-0 start-0 px-3 md:px-5 pt-3 transition-all duration-300"
>
    <div class="relative w-full px-8 py-5 bg-white/38 dark:bg-[#0a0a0a]/46 backdrop-blur-3xl backdrop-saturate-150 border border-white/45 dark:border-white/[0.16] shadow-[0_8px_30px_rgba(0,0,0,0.08)] dark:shadow-[0_8px_30px_rgba(0,0,0,0.28)] rounded-[1.25rem]"
         @click.outside="open = false"
         :class="[
            scrolled ? '!py-3 shadow-sm' : '',
            navTransitionEnabled ? 'transition-all duration-300' : 'transition-none',
         ]">
        <!-- Flex container: Logo | Nav links + Theme + CTA -->
        <div class="flex items-center justify-between">

            {{-- Logo: ola magnética (base) + brillo metálico del footer (capa absoluta); colores vía .navbar-logo-char-* + html.dark --}}
            @php
                $navLogo = 'CARLOS.CODEX';
            @endphp
            <a href="{{ route('home') }}"
               class="shrink-0 inline-flex items-center"
               style="font-family: 'JetBrains Mono', 'Fira Code', ui-monospace, monospace; font-weight: 700; font-size: 19px; letter-spacing: 0.04em; text-decoration: none;">
                <span class="js-footer-design-spotlight footer-design-wrapper navbar-brand-vfx relative inline-block whitespace-nowrap leading-none">
                    <span class="js-footer-name-spotlight js-hero-wave hero-name-vfx footer-name-wrapper footer-magnetic-vfx navbar-logo-wave relative inline-block leading-none">
                        <span class="footer-name-vfx-base">@foreach (mb_str_split($navLogo) as $i => $char)<span class="footer-name-char hero-wave-char {{ $i < 6 ? 'navbar-logo-char-main' : 'navbar-logo-char-muted' }}" style="--char-index: {{ $i }}">{{ $char }}</span>@endforeach</span>
                        <span class="footer-design-reflection navbar-brand-metallic-overlay" aria-hidden="true">@foreach (mb_str_split($navLogo) as $i => $char)<span class="footer-name-char hero-wave-char navbar-brand-metallic-char" style="--char-index: {{ $i }}">{{ $char }}</span>@endforeach</span>
                    </span>
                </span>
            </a>

            <!-- MENÚ DERECHA (desktop) + Controles -->
            <div class="flex items-center gap-6">

                <!-- DESKTOP -->
                <ul class="hidden md:flex items-center gap-8"
                    style="font-family: 'Geist', 'Inter', system-ui, sans-serif; font-size: 16px; font-weight: 500; list-style: none; margin: 0; padding: 0;">
                    <li>
                        <a href="{{ route('public.about') }}"
                           @click="open = false; if (isAboutPage) $event.preventDefault()"
                           class="inline-block pb-0.5 transition-[color,border-color] duration-300 ease-out {{ $isAbout ? $navActiveDesktop : $navInactiveDesktop }}"
                           style="text-decoration: none;"
                           @if($isAbout) aria-current="page" @endif>
                           Sobre mí
                        </a>
                    </li>
                    <li>
                        <a href="{{ $isHome ? '#skills' : route('home') . '#skills' }}"
                           @click="open = false"
                           class="inline-block pb-0.5 transition-[color,border-color] duration-300 ease-out {{ $navInactiveDesktop }}"
                           style="text-decoration: none;"
                           :class="(isHome && activeHomeSection === 'skills') ? navScrollActiveDesktop : ''">
                           Habilidades
                        </a>
                    </li>
                    <li>
                        <a href="{{ $isHome ? '#projects' : route('home') . '#projects' }}"
                           @click="open = false"
                           class="inline-block pb-0.5 transition-[color,border-color] duration-300 ease-out {{ $isProjectsListing ? $navActiveDesktop : $navInactiveDesktop }}"
                           style="text-decoration: none;"
                           @if($isProjectsListing) aria-current="page" @endif
                           :aria-current="(isProjectsPage || (isHome && activeHomeSection === 'projects')) ? 'page' : null"
                           :class="(isHome && activeHomeSection === 'projects' && !isProjectsPage) ? navScrollActiveDesktop : ''">
                           Proyectos
                        </a>
                    </li>
                </ul>

                <!-- THEME TOGGLE -->
                <x-theme-toggle />

                <!-- HABLEMOS CTA (desktop) -->
                <a href="{{ $isHome ? '#contact' : route('home') . '#contact' }}"
                   @click="open = false"
                   class="group hidden md:inline-flex items-center gap-2.5 border border-gray-900 dark:border-white/80 rounded-full text-gray-900 dark:text-white hover:bg-gray-900 dark:hover:bg-white hover:text-white dark:hover:text-gray-900 transition-all duration-[220ms] ease-[cubic-bezier(0.34,1.56,0.64,1)] hover:scale-[1.045]"
                   style="font-family: 'Geist', 'Inter', system-ui, sans-serif; font-size: 15px; font-weight: 500; padding: 8px 18px 8px 10px; text-decoration: none;"
                   :class="(isHome && activeHomeSection === 'contact') ? '!border-indigo-600 dark:!border-indigo-400 ring-2 ring-indigo-600/25 dark:ring-indigo-400/30' : ''">
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
                              x-show="open" style="display: none" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>

        <!-- MOBILE -->
        <div class="md:hidden grid transition-[grid-template-rows] duration-300 ease-[cubic-bezier(0.4,0,0.2,1)] motion-reduce:transition-none"
             style="grid-template-rows: 0fr"
             :style="{ gridTemplateRows: open ? '1fr' : '0fr' }">
            <div class="min-h-0 overflow-hidden">
                <div class="border-t border-white/45 dark:border-white/[0.16] mt-3 pt-1 -mx-8 px-8">
                    <ul class="flex flex-col gap-0 pb-1"
                        style="font-family: 'Geist', 'Inter', system-ui, sans-serif; font-size: 16px; font-weight: 500; list-style: none; margin: 0; padding-top: 8px; padding-bottom: 8px;">
                        <li>
                            <a href="{{ route('public.about') }}"
                               @click="open = false; if (isAboutPage) $event.preventDefault()"
                               class="block py-2.5 pl-3 pr-2 rounded-md border-l-4 transition-[color,border-color,background-color] duration-300 ease-out {{ $isAbout ? $navActiveMobile : $navInactiveMobile }}"
                               style="text-decoration: none;"
                               @if($isAbout) aria-current="page" @endif>
                               Sobre mí
                            </a>
                        </li>
                        <li>
                            <a href="{{ $isHome ? '#skills' : route('home') . '#skills' }}"
                               @click="open = false"
                               class="block py-2.5 pl-3 pr-2 rounded-md border-l-4 transition-[color,border-color,background-color] duration-300 ease-out {{ $navInactiveMobile }}"
                               style="text-decoration: none;"
                               :class="(isHome && activeHomeSection === 'skills') ? navScrollActiveMobile : ''">
                               Habilidades
                            </a>
                        </li>
                        <li>
                            <a href="{{ $isHome ? '#projects' : route('home') . '#projects' }}"
                               @click="open = false"
                               class="block py-2.5 pl-3 pr-2 rounded-md border-l-4 transition-[color,border-color,background-color] duration-300 ease-out {{ $isProjectsListing ? $navActiveMobile : $navInactiveMobile }}"
                               style="text-decoration: none;"
                               @if($isProjectsListing) aria-current="page" @endif
                               :aria-current="(isProjectsPage || (isHome && activeHomeSection === 'projects')) ? 'page' : null"
                               :class="(isHome && activeHomeSection === 'projects' && !isProjectsPage) ? navScrollActiveMobile : ''">
                               Proyectos
                            </a>
                        </li>
                        <li class="pt-3 pb-1">
                            <a href="{{ $isHome ? '#contact' : route('home') . '#contact' }}"
                               @click="open = false"
                               class="group inline-flex items-center gap-2.5 border border-gray-900 dark:border-white/80 rounded-full text-gray-900 dark:text-white hover:bg-gray-900 dark:hover:bg-white hover:text-white dark:hover:text-gray-900 transition-all duration-[220ms] ease-[cubic-bezier(0.34,1.56,0.64,1)] hover:scale-[1.045]"
                               style="font-size: 15px; font-weight: 500; padding: 8px 18px 8px 10px; text-decoration: none;"
                               :class="(isHome && activeHomeSection === 'contact') ? '!border-indigo-600 dark:!border-indigo-400 ring-2 ring-indigo-600/25 dark:ring-indigo-400/30' : ''">
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

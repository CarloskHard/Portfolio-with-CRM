{{-- COMPONENTE DE NAVEGACIÓN PÚBLICA --}}
@php
    $currentRoute = Route::currentRouteName();
    
    $isHome = $currentRoute === 'home';
    // Ajusta estos arrays con los nombres reales de tus rutas
    $isAboutPage = in_array($currentRoute, ['public.about', 'about']); 
    $isProjectsPage = in_array($currentRoute, ['public.projects', 'projects', 'projects.index']); 
@endphp

<!-- Añadido x-cloak para evitar parpadeos y @click.outside para cerrar al tocar fuera -->
<nav x-data="{ open: false }" @click.outside="open = false" class="fixed w-full z-50 top-0 start-0 bg-white/80 dark:bg-gray-900/80 backdrop-blur-md border-b border-gray-100 dark:border-gray-800 transition-colors duration-300">
    <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
        
        <!-- Logo -->
        <a href="{{ route('home') }}" class="flex items-center space-x-3 rtl:space-x-reverse group">
            <img src="{{ asset('img/logo.png') }}" class="h-10 w-10 rounded-full shadow-sm" alt="Logo">
            <span class="js-footer-design-spotlight footer-design-wrapper self-center text-xl font-bold whitespace-nowrap text-gray-900 dark:text-indigo-400 inline-block cursor-default relative">
                <span class="footer-design-base">Carlos Codex</span>
                <span class="footer-design-reflection" aria-hidden="true">Carlos Codex</span>
            </span>
        </a>
        
        <div class="flex items-center gap-4 md:order-2">
            <x-theme-toggle />
            
            <!-- BOTÓN MÓVIL -->
            <button @click="open = !open" type="button" 
                class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm rounded-lg md:hidden focus:outline-none transition-colors"
                :class="{
                    'bg-gray-100 text-gray-900 dark:bg-gray-700 dark:text-white': open, 
                    'text-gray-500 dark:text-gray-400': !open
                }"
            >
                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15"/>
                </svg>
            </button>
        </div>

        <!-- Menú Desplegable -->
        <div :class="{'block': open, 'hidden': !open}" class="hidden w-full md:block md:w-auto" id="navbar-sticky">
            <ul class="font-medium flex flex-col p-4 md:p-0 mt-4 md:flex-row md:space-x-8 rtl:space-x-reverse md:mt-0">
                
                <!-- SOBRE MÍ -->
                <li>
                    @if($isAboutPage)
                        <span class="block py-2 px-3 text-indigo-600 dark:text-indigo-400 font-bold cursor-default">
                            Sobre mí
                        </span>
                    @else
                        <a @click="open = false" href="{{ $isHome ? '#about' : route('home') . '#about' }}" 
                           class="block py-2 px-3 text-gray-900 hover:text-indigo-600 dark:text-white dark:hover:text-indigo-400 transition-colors">
                           Sobre mí
                        </a>
                    @endif
                </li>
                
                <!-- HABILIDADES -->
                <li>
                    <a @click="open = false" href="{{ $isHome ? '#skills' : route('home') . '#skills' }}" 
                       class="block py-2 px-3 text-gray-900 hover:text-indigo-600 dark:text-white dark:hover:text-indigo-400 transition-colors">
                       Habilidades
                    </a>
                </li>
                
                <!-- PROYECTOS -->
                <li>
                    @if($isProjectsPage)
                        <span class="block py-2 px-3 text-indigo-600 dark:text-indigo-400 font-bold cursor-default">
                            Proyectos
                        </span>
                    @else
                        <a @click="open = false" href="{{ $isHome ? '#projects' : route('home') . '#projects' }}" 
                           class="block py-2 px-3 text-gray-900 hover:text-indigo-600 dark:text-white dark:hover:text-indigo-400 transition-colors">
                           Proyectos
                        </a>
                    @endif
                </li>
                
                <!-- CONTACTO -->
                <li>
                    <a @click="open = false" href="{{ $isHome ? '#contact' : route('home') . '#contact' }}" 
                       class="block py-2 px-3 text-gray-900 hover:text-indigo-600 dark:text-white dark:hover:text-indigo-400 transition-colors">
                       Contacto
                    </a>
                </li>

            </ul>
        </div>
    </div>
</nav>
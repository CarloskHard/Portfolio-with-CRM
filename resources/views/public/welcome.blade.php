<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Carlos Codes | Full Stack Developer</title>
        <link rel="icon" href="{{ asset('img/logo.png') }}" type="image/png">
        
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600,800&display=swap" rel="stylesheet" />

        <!-- Scripts & Styles -->
        @vite([
            'resources/css/app.css', 
            'resources/js/app.js', 
            'resources/css/spotlight.css', 
            'resources/js/spotlight.js',
            'resources/js/bg_code.js',
        ])

        <style>
            /* Ocultar Barra de Scroll */
            .no-scrollbar::-webkit-scrollbar { display: none; }
            .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
            
            /* Clases utilitarias para las skills con HOVER EFFECT */
            .skill-tag {
                display: inline-flex;
                align-items: center;
                padding: 0.25rem 0.75rem;
                background-color: #f9fafb; /* bg-gray-50 */
                border: 1px solid #e5e7eb; /* border-gray-200 */
                border-radius: 9999px;
                font-size: 0.875rem;
                font-weight: 500;
                color: #374151; /* text-gray-700 */
                cursor: default;
                transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            }
            /* Efecto Hover recuperado */
            .skill-tag:hover {
                transform: scale(1.05);
                border-color: #818cf8; /* indigo-400 */
                background-color: #eef2ff; /* indigo-50 */
                color: #4f46e5; /* indigo-600 */
            }

            /* Dark Mode para skills */
            .dark .skill-tag {
                background-color: #1f2937; /* bg-gray-800 */
                border-color: #374151; /* border-gray-700 */
                color: #d1d5db; /* text-gray-300 */
            }
            .dark .skill-tag:hover {
                background-color: #312e81; /* indigo-900 */
                border-color: #6366f1; /* indigo-500 */
                color: #a5b4fc; /* indigo-300 */
            }

            /* Botones del Footer */
            .footer-btn {
                display: inline-flex;
                align-items: center;
                gap: 0.625rem; /* Espacio entre icono y texto */
                padding: 0.5rem 0.75rem;
                background-color: transparent;
                border: 1px solid transparent;
                border-radius: 0.5rem;
                font-size: 0.875rem;
                font-weight: 500;
                color: #9ca3af; /* text-gray-400 */
                transition: all 0.3s ease;
                cursor: pointer;
            }

            /* El hover general (se activa por la clase 'group' en el <a>) */
            .group:hover .footer-btn {
                background-color: rgba(31, 41, 55, 0.5); /* Un fondo muy sutil al pasar el ratón */
            }

            /* Colores específicos de hover para los iconos */
            .group:hover .icon-linkedin { color: #0077b5; }
            .group:hover .icon-github { color: #3CCF91; }
            .group:hover .icon-email { color: #818cf8; }

            /* 1. Ocultar barra de scroll nativa para todo el documento */
            html {
                scrollbar-width: none; /* Firefox */
                -ms-overflow-style: none; /* IE/Edge */
            }
            html::-webkit-scrollbar {
                display: none; /* Chrome, Safari, Opera */
            }

            /* 2. Estilos de la barra de progreso vertical */
            #scroll-progress-container {
                position: fixed;
                right: 0;
                top: 0;
                width: 4px; /* Grosor de la barra */
                height: 100%;
                background-color: rgba(229, 231, 235, 0.3); /* Gris muy sutil (fondo) */
                z-index: 100; /* Por encima de todo */
            }

            .dark #scroll-progress-container {
                background-color: rgba(55, 65, 81, 0.3); /* Fondo oscuro en modo dark */
            }

            #scroll-progress-bar {
                width: 100%;
                height: 0%; /* Empezará en 0 */
                background: linear-gradient(to bottom, #818cf8, #4f46e5); /* Degradado índigo */
                box-shadow: 0 0 8px rgba(79, 70, 229, 0.5);
                transition: height 0.1s ease-out;
            }

            /* Animación de flotado fluido y multidireccional */
            @keyframes float-natural {
                0% {
                    transform: translate(0, 0) rotate(0deg);
                }
                33% {
                    transform: translate(5px, -10px) rotate(2deg);
                }
                66% {
                    transform: translate(-5px, -15px) rotate(-2deg);
                }
                100% {
                    transform: translate(0, 0) rotate(0deg);
                }
            }

            .animate-floating {
                /* El cubic-bezier hace que el arranque y frenada sean más elásticos */
                animation: float-natural 6s cubic-bezier(0.45, 0.05, 0.55, 0.95) infinite;
            }

            /* Efecto Respiración Sutil */
            @keyframes soft-breath {
                0%, 100% {
                    transform: scale(1);
                    box-shadow: 0 0 0 0 rgba(129, 140, 248, 0); /* Indigo transparente */
                }
                50% {
                    transform: scale(1.03);
                    box-shadow: 0 0 15px 2px rgba(129, 140, 248, 0.2); /* Brillo muy suave */
                }
            }

            .animate-subtle-breath {
                animation: soft-breath 5s ease-in-out infinite;
                display: inline-block; /* Asegura que la transformación funcione bien */
            }
        </style>

        <!-- Script Anti-Flash para Modo Oscuro -->
        <script>
            if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        </script>
    </head>
    <body class="antialiased bg-gray-50 text-gray-900 dark:bg-gray-900 dark:text-gray-100 font-sans flex flex-col min-h-screen transition-colors duration-300">
        <!-- Barra de progreso vertical -->
        <div id="scroll-progress-container">
            <div id="scroll-progress-bar"></div>
        </div>

        <!-- NAVBAR -->
        <nav class="fixed w-full z-50 top-0 start-0 bg-white/80 dark:bg-gray-900/80 backdrop-blur-md border-b border-gray-100 dark:border-gray-800 transition-colors duration-300">
            <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
                <a href="#" class="flex items-center space-x-3 rtl:space-x-reverse group">
                    <img src="{{ asset('img/logo.png') }}" class="h-10 w-10 rounded-full shadow-sm" alt="Logo">
                    <span class="self-center text-xl font-bold whitespace-nowrap text-gray-900 dark:text-white group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors">Carlos Codes</span>
                </a>
                
                <div class="flex items-center gap-4 md:order-2">
                    <x-theme-toggle />
                    <button data-collapse-toggle="navbar-sticky" type="button" class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 focus:outline-none">
                        <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15"/></svg>
                    </button>
                </div>

                <div class="hidden w-full md:block md:w-auto" id="navbar-sticky">
                    <ul class="font-medium flex flex-col p-4 md:p-0 mt-4 border border-gray-100 rounded-lg bg-gray-50 md:flex-row md:space-x-8 rtl:space-x-reverse md:mt-0 md:border-0 md:bg-transparent dark:bg-gray-800 md:dark:bg-transparent dark:border-gray-700">
                        <li><a href="#about" class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-indigo-600 md:p-0 dark:text-white dark:hover:text-indigo-400 dark:hover:bg-gray-700 md:dark:hover:bg-transparent transition">Sobre mí</a></li>
                        <li><a href="#skills" class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-indigo-600 md:p-0 dark:text-white dark:hover:text-indigo-400 dark:hover:bg-gray-700 md:dark:hover:bg-transparent transition">Habilidades</a></li>
                        <li><a href="#projects" class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-indigo-600 md:p-0 dark:text-white dark:hover:text-indigo-400 dark:hover:bg-gray-700 md:dark:hover:bg-transparent transition">Proyectos</a></li>
                        <li><a href="#contact" class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-indigo-600 md:p-0 dark:text-white dark:hover:text-indigo-400 dark:hover:bg-gray-700 md:dark:hover:bg-transparent transition">Contacto</a></li>
                    </ul>
                </div>
            </div>
        </nav>

        <!-- MAIN CONTENT -->
        <main class="flex-grow">
            
            <!-- HERO SECTION -->
            <section id="home" class="relative pt-32 pb-20 bg-white dark:bg-gray-900 overflow-hidden transition-colors duration-300">
                <!-- Canvas para el fondo de código -->
                <canvas id="code-canvas" class="absolute top-0 left-0 w-full h-full pointer-events-none opacity-[1] dark:opacity-[1]"></canvas>

                <div class="grid max-w-screen-xl px-4 py-8 mx-auto lg:gap-8 xl:gap-0 lg:py-16 lg:grid-cols-12 items-center">
                    
                    <div class="mr-auto place-self-center lg:col-span-7 z-10">
                        <span class="inline-block py-1 px-3 rounded-full bg-indigo-100 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-300 text-sm font-semibold mb-4 animate-subtle-breath border border-indigo-200 dark:border-indigo-800/50">
                            🚀 Disponible para nuevos proyectos
                        </span>
                        <h1 class="max-w-2xl mb-4 text-4xl font-extrabold tracking-tight leading-none md:text-5xl xl:text-6xl text-gray-900 dark:text-white">
                            Hola 👋🏼, soy <br> <span class="text-indigo-600 dark:text-indigo-400">Carlos Codes</span>
                        </h1>
                        <p class="max-w-2xl mb-8 font-light text-gray-600 dark:text-gray-400 lg:mb-8 md:text-lg lg:text-xl leading-relaxed">
                            Desarrollador Full Stack web y móvil
                        </p>
                        
                        <div class="flex flex-wrap items-center gap-4">
                            <a href="#projects" class="inline-flex items-center justify-center px-5 py-3 text-base font-medium text-center text-white rounded-lg bg-gray-900 hover:bg-gray-800 dark:bg-indigo-600 dark:hover:bg-indigo-700 transition">
                                Ver Proyectos
                            </a>
                            <a href="#contact" class="inline-flex items-center justify-center px-5 py-3 text-base font-medium text-center text-gray-900 border border-gray-300 rounded-lg hover:bg-gray-100 dark:text-white dark:border-gray-600 dark:hover:bg-gray-800 transition">
                                Contactar
                            </a>
                            
                            <div class="w-full sm:w-auto h-0 sm:h-8 border-t sm:border-l border-gray-300 dark:border-gray-700 mx-0 sm:mx-2"></div>

                            <a href="{{ env('APP_GITHUB_URL') }}" target="_blank" class="text-gray-500 hover:text-black dark:text-gray-400 dark:hover:text-white transition" title="GitHub">
                                <x-icons.github class="w-7 h-7" />
                            </a>
                            <a href="{{ env('APP_LINKEDIN_URL') }}" target="_blank" class="text-gray-500 hover:text-[#0077b5] dark:text-gray-400 dark:hover:text-[#0077b5] transition" title="LinkedIn">
                                <x-icons.linkedin class="w-7 h-7" />
                            </a>
                        </div>
                    </div>
                    
                    <div class="hidden lg:mt-0 lg:col-span-5 lg:flex justify-end relative">
                        <div class="relative w-80 h-80">
                            <div class="absolute top-0 right-0 w-72 h-72 bg-indigo-200 dark:bg-indigo-900 rounded-full blur-3xl opacity-40"></div>
                            
                            <div class="relative w-full h-full rounded-full border-4 border-white dark:border-gray-800 shadow-xl overflow-hidden bg-gray-100 dark:bg-gray-800">
                                <img src="{{ asset('img/me.png') }}" onerror="this.src='{{ asset('img/logo.png') }}'" alt="Carlos Codes" class="w-full h-full object-cover">
                            </div>

                            <!-- ADORNO PORTATIL ANIMADO -->
                            <div class="absolute bottom-4 left-0 bg-white dark:bg-gray-800 p-3 rounded-full shadow-lg border border-gray-100 dark:border-gray-700 text-indigo-600 dark:text-indigo-400 animate-floating">
                                <x-icons.laptop class="w-8 h-8" />
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- SKILLS SECTION (6 CARDS + HOVER EFFECT) -->
            <section id="skills" class="py-20 bg-gray-50 dark:bg-gray-800 border-y border-gray-100 dark:border-gray-700 transition-colors duration-300">
                <div class="max-w-screen-xl px-4 mx-auto">
                    <div class="mb-12">
                        <h2 class="text-3xl font-bold text-gray-900 dark:text-white">Habilidades Técnicas</h2>
                        <div class="w-20 h-1.5 bg-indigo-600 mt-4 rounded-full"></div>
                        <p class="text-gray-600 dark:text-gray-300 max-w-4xl mt-4 text-lg leading-relaxed">
                            Trato con una gran gama de tecnologías pues he trabajado desde webs dinámicas (Desde portfolios hasta CRMs, ERPs y CMS) hasta aplicaciones móviles (Tanto nativas como multiplataforma) en completo fullstack.
                        </p>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        
                        <!-- CARD 1: Lenguajes -->
                        <div class="skill-card js-spotlight-card bg-white dark:bg-gray-900 rounded-xl p-6 shadow-sm border border-gray-200 dark:border-gray-700 transition-all duration-300 hover:-translate-y-0.5">
                            <div class="flex items-center gap-3 mb-4">
                                <div class="p-2 bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 rounded-lg">
                                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/></svg>
                                </div>
                                <h3 class="text-lg font-bold text-gray-900 dark:text-white">Lenguajes</h3>
                            </div>
                            <div class="flex flex-wrap gap-2">
                                <span class="skill-tag">PHP</span>
                                <span class="skill-tag">JavaScript</span>
                                <span class="skill-tag">Java</span>
                                <span class="skill-tag">SQL</span>
                            </div>
                        </div>

                        <!-- CARD 2: Frontend -->
                        <div class="skill-card js-spotlight-card bg-white dark:bg-gray-900 rounded-xl p-6 shadow-sm border border-gray-200 dark:border-gray-700 transition-all duration-300 hover:-translate-y-0.5">
                            <div class="flex items-center gap-3 mb-4">
                                <div class="p-2 bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 rounded-lg">
                                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><rect width="18" height="18" x="3" y="3" rx="2"></rect><path d="M3 9h18"></path></svg>
                                </div>
                                <h3 class="text-lg font-bold text-gray-900 dark:text-white">Frontend</h3>
                            </div>
                            <div class="flex flex-wrap gap-2">
                                <span class="skill-tag">Tailwind</span>
                                <span class="skill-tag">React</span>
                                <span class="skill-tag">Blade</span>
                                <span class="skill-tag">Alpine.js</span>
                            </div>
                        </div>

                        <!-- CARD 3: Backend -->
                        <div class="skill-card js-spotlight-card bg-white dark:bg-gray-900 rounded-xl p-6 shadow-sm border border-gray-200 dark:border-gray-700 transition-all duration-300 hover:-translate-y-0.5">
                            <div class="flex items-center gap-3 mb-4">
                                <div class="p-2 bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 rounded-lg">
                                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M12 5l7 7-7 7"/></svg>
                                </div>
                                <h3 class="text-lg font-bold text-gray-900 dark:text-white">Backend</h3>
                            </div>
                            <div class="flex flex-wrap gap-2">
                                <span class="skill-tag">Laravel</span>
                                <span class="skill-tag">Node.js</span>
                                <span class="skill-tag">Spring Boot</span>
                                <span class="skill-tag">REST APIs</span>
                            </div>
                        </div>

                        <!-- CARD 4: Base de Datos -->
                        <div class="skill-card js-spotlight-card bg-white dark:bg-gray-900 rounded-xl p-6 shadow-sm border border-gray-200 dark:border-gray-700 transition-all duration-300 hover:-translate-y-0.5">
                            <div class="flex items-center gap-3 mb-4">
                                <div class="p-2 bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 rounded-lg">
                                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><ellipse cx="12" cy="5" rx="9" ry="3"></ellipse><path d="M3 5V19A9 3 0 0 0 21 19V5"></path><path d="M3 12A9 3 0 0 0 21 12"></path></svg>
                                </div>
                                <h3 class="text-lg font-bold text-gray-900 dark:text-white">Base de Datos</h3>
                            </div>
                            <div class="flex flex-wrap gap-2">
                                <span class="skill-tag">MySQL</span>
                                <span class="skill-tag">PostgreSQL</span>
                                <span class="skill-tag">HeidiSQL</span>
                                <span class="skill-tag">Eloquent ORM</span>
                            </div>
                        </div>

                        <!-- CARD 5: Herramientas -->
                        <div class="skill-card js-spotlight-card bg-white dark:bg-gray-900 rounded-xl p-6 shadow-sm border border-gray-200 dark:border-gray-700 transition-all duration-300 hover:-translate-y-0.5">
                            <div class="flex items-center gap-3 mb-4">
                                <div class="p-2 bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 rounded-lg">
                                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><rect width="16" height="16" x="4" y="4" rx="2"></rect><path d="M15 2v2"></path><path d="M15 20v2"></path><path d="M2 15h2"></path><path d="M20 15h2"></path></svg>
                                </div>
                                <h3 class="text-lg font-bold text-gray-900 dark:text-white">Herramientas</h3>
                            </div>
                            <div class="flex flex-wrap gap-2">
                                <span class="skill-tag">Git / GitHub</span>
                                <span class="skill-tag">Docker</span>
                                <span class="skill-tag">VS Code</span>
                                <span class="skill-tag">Postman</span>
                            </div>
                        </div>

                        <!-- CARD 6: Diseño -->
                        <div class="skill-card js-spotlight-card bg-white dark:bg-gray-900 rounded-xl p-6 shadow-sm border border-gray-200 dark:border-gray-700 transition-all duration-300 hover:-translate-y-0.5">
                            <div class="flex items-center gap-3 mb-4">
                                <div class="p-2 bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 rounded-lg">
                                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"></circle><path d="M14.31 8l5.74 9.94M9.69 8h11.48M7.38 12l5.74-9.94M9.69 16L3.95 6.06M14.31 16H2.83m13.79-4l-5.74 9.94"/></svg>
                                </div>
                                <h3 class="text-lg font-bold text-gray-900 dark:text-white">Diseño</h3>
                            </div>
                            <div class="flex flex-wrap gap-2">
                                <span class="skill-tag">Figma</span>
                                <span class="skill-tag">Wireframing</span>
                                <span class="skill-tag">Responsive</span>
                                <span class="skill-tag">UI/UX</span>
                            </div>
                        </div>

                    </div>
                </div>
            </section>

            <!-- PROJECTS SECTION -->
            <section id="projects" class="py-24 bg-white dark:bg-gray-900 transition-colors duration-300">
                <div class="max-w-screen-xl px-4 mx-auto">
                    
                    <div class="mb-16">
                        <h2 class="text-3xl font-extrabold text-gray-900 dark:text-white">Proyectos</h2>
                        <div class="w-20 h-1.5 bg-indigo-600 mt-4 rounded-full"></div>
                    </div>

                    <!-- Grid limitado a 3 -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        @forelse($projects->take(3) as $project)
                            <article class="project-card js-project-card bg-gray-50 dark:bg-gray-800/50 rounded-2xl overflow-hidden border border-gray-200 dark:border-gray-700 flex flex-col h-full shadow-sm">
                                
                                <!-- Imagen / Fallback -->
                                <div class="relative aspect-video overflow-hidden bg-gray-100 dark:bg-gray-800 flex items-center justify-center">
                                    @if($project->image_url)
                                        <img src="{{ asset($project->image_url) }}" class="w-full h-full object-cover">
                                    @else
                                        <img src="{{ asset('img/logo.png') }}" class="w-16 h-16">
                                    @endif
                                </div>

                                <!-- Contenido -->
                                <div class="p-6 flex-grow flex flex-col relative z-10">
                                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">{{ $project->title }}</h3>
                                    <p class="text-gray-600 dark:text-gray-400 text-sm mb-6 flex-grow leading-relaxed">{{ $project->description }}</p>

                                    <!-- Etiquetas dinámicas-->
                                    <div class="flex flex-wrap gap-2 pt-4 border-t border-gray-200 dark:border-gray-700">
                                        @php
                                            $techs = is_string($project->technologies) ? explode(',', $project->technologies) : $project->technologies;
                                        @endphp
                                        @if($techs)
                                            @foreach($techs as $tech)
                                                <span class="skill-tag">{{ trim($tech instanceof \App\Models\Technology ? $tech->name : $tech) }}</span>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </article>
                        @empty
                            <p class="col-span-full text-center text-gray-500 py-12">No hay proyectos destacados.</p>
                        @endforelse
                    </div>

                    <!-- Botón Ver Más -->
                    <div class="mt-16 text-center">
                        <a href="/proyectos" 
                        class="group inline-flex items-center gap-3 px-8 py-2 rounded-xl border border-gray-300 dark:border-gray-700 text-gray-700 dark:text-gray-300 font-bold text-sm tracking-wide transition-all duration-200 hover:scale-105 hover:bg-indigo-600 hover:text-white hover:border-indigo-600 hover:shadow-indigo-500/30">
                            Ver más proyectos 
                            <span class="text-indigo-600 dark:text-indigo-400 font-mono text-lg transition-transform duration-300 group-hover:text-white group-hover:translate-x-1">
                                &lt;&gt;
                            </span>
                        </a>
                    </div>

                </div>
            </section>

            <!-- SOBRE MÍ SECTION -->
            <section id="about" class="py-24 bg-gray-50 dark:bg-gray-800/50 transition-colors duration-300">
                <div class="max-w-screen-xl px-4 mx-auto">
                    <div class="flex flex-col lg:flex-row gap-12 items-center">
                        
                        <!-- Columna Imagen/Decoración -->
                        <div class="w-full lg:w-1/3 relative group">
                            <div class="relative z-10 overflow-hidden rounded-2xl shadow-2xl transition-transform duration-500 group-hover:-translate-y-2">
                                <!-- Puedes poner otra foto tuya o una representativa -->
                                <img src="{{ asset('img/me-alt.png') }}" onerror="this.src='{{ asset('img/logo.png') }}'" alt="Carlos trabajando" class="w-full h-auto object-cover">
                                <div class="absolute inset-0 bg-indigo-600/10"></div>
                            </div>
                            <!-- Elementos decorativos de fondo -->
                            <div class="absolute -bottom-6 -right-6 w-32 h-32 bg-indigo-500/10 rounded-full blur-2xl"></div>
                            <div class="absolute -top-6 -left-6 w-32 h-32 bg-blue-500/10 rounded-full blur-2xl"></div>
                        </div>

                        <!-- Columna Texto -->
                        <div class="w-full lg:w-2/3">

                            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-6">
                                Arquitectura sólida para <span class="text-indigo-600 dark:text-indigo-400">ideas complejas.</span>
                            </h2>

                            <div class="space-y-5 text-lg text-gray-600 dark:text-gray-300 leading-relaxed">
                                <p>
                                    ¡Hola! Soy Carlos. Mi trayectoria empezó en el desarrollo de <strong class="text-gray-900 dark:text-white font-semibold">videojuegos</strong>, donde aprendí el valor del rendimiento y la optimización de recursos.
                                </p>
                                <p>
                                    He trabajado en entornos de alta exigencia dentro del <strong class="text-gray-900 dark:text-white font-semibold">ecosistema Apple</strong> y diseñado la lógica central de sistemas críticos como <strong class="text-gray-900 dark:text-white font-semibold">CRMs y ERPs</strong>.
                                </p>
                                <p>
                                    Hoy me enfoco en la <strong class="text-gray-900 dark:text-white font-semibold">arquitectura de software</strong> aplicada al desarrollo Web y Móvil. Mi prioridad es construir código limpio, escalable y preparado para crecer sin deuda técnica.
                                </p>
                            </div>


                            <!-- Estadísticas rápidas -->
                            <div class="grid grid-cols-2 md:grid-cols-3 gap-6 mt-10">
                                <!-- Experiencia Total -->
                                <div class="flex flex-col">
                                    <span class="text-3xl font-extrabold text-indigo-600 dark:text-indigo-400">+5</span>
                                    <span class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Años de experiencia</span>
                                </div>

                                <!-- Enfoque en Sistemas Complejos -->
                                <div class="flex flex-col">
                                    <span class="text-3xl font-extrabold text-indigo-600 dark:text-indigo-400">ERPs/CRMs</span>
                                    <span class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Desarrollados</span>
                                </div>

                                <!-- Versatilidad Técnica -->
                                <div class="flex flex-col col-span-2 md:col-span-1">
                                    <span class="text-3xl font-extrabold text-indigo-600 dark:text-indigo-400">SOLID</span>
                                    <span class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Arquitectura y Patrones</span>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </section>

            <!-- SECCIÓN DE CONTACTO -->
            <section id="contact" class="py-20 bg-gray-50 dark:bg-gray-800 border-t border-gray-100 dark:border-gray-700 transition-colors duration-300">
                <div class="max-w-screen-md mx-auto px-4">
                    <div class="text-center mb-12">
                        <h2 class="text-3xl font-bold text-gray-900 dark:text-white">¿Trabajamos juntos?</h2>
                        <div class="w-32 h-1.5 bg-indigo-600 mt-4 rounded-full mx-auto"></div>
                        
                        <!-- Mensaje de Éxito con estilo Dark Mode -->
                        @if (session('status'))
                            <div class="mt-4 p-4 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300 rounded-lg border border-green-200 dark:border-green-800">
                                {{ session('status') }}
                            </div>
                        @else
                            <p class="mt-4 text-gray-500 dark:text-gray-400">Envíame un mensaje y te responderé lo antes posible.</p>
                        @endif
                    </div>

                    <div class="bg-white dark:bg-gray-900 p-8 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
           
                        <!-- FORMULARIO FUNCIONAL -->
                        <form action="{{ route('contact.store') }}" method="POST" class="space-y-6">
                            @csrf
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- NOMBRE -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nombre</label>
                                    <input type="text" name="name" value="{{ old('name') }}" required 
                                        class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 transition-colors">
                                    @error('name')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- EMAIL -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Email</label>
                                    <input type="email" name="email" value="{{ old('email') }}" required 
                                        class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 transition-colors">
                                    @error('email')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- MENSAJE -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Mensaje</label>
                                <textarea name="content" rows="4" required 
                                    class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 transition-colors">{{ old('content') }}</textarea>
                                @error('content')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div class="pt-4">
                                <button type="submit"
                                    class="w-full px-6 py-3 bg-indigo-600 text-white font-medium rounded-lg hover:bg-indigo-700 transition shadow-lg shadow-indigo-500/30">
                                    Enviar Mensaje
                                </button>
                            </div>
                        </form>
                        <div class="mt-5 text-center">
                            <span class="text-sm text-gray-400 mb-3"> O si lo prefieres: </span>

                            <a href="mailto:{{ env('APP_CONTACT_EMAIL') }}"
                            class="inline-flex items-center gap-2 px-4 py-2 text-sm
                                    bg-white dark:bg-gray-800
                                    border border-gray-300 dark:border-gray-600
                                    text-gray-600 dark:text-gray-400
                                    rounded-md
                                    hover:bg-gray-50 dark:hover:bg-gray-700
                                    transition opacity-80 hover:opacity-100">
                                <svg class="w-4 h-4 text-red-500" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M24 5.457v13.909c0 .904-.732 1.636-1.636 1.636h-3.819V11.73L12 16.64l-6.545-4.91v9.273H1.636A1.636 1.636 0 0 1 0 19.366V5.457c0-2.023 2.309-3.178 3.927-1.964L5.455 4.64 12 9.548l6.545-4.91 1.528-1.145C21.69 2.28 24 3.434 24 5.457z"/>
                                </svg>
                                Contactar por email
                            </a>
                        </div>
                    </div>
                </div>
            </section>

        </main>

        <!-- FOOTER -->
        <footer id="main-footer" class="bg-[#0b0f1a] text-gray-400 py-10 border-t border-gray-800/50">
            <div class="max-w-7xl mx-auto px-8 md:px-12 flex flex-col md:flex-row justify-between items-center gap-8">
                
                <!-- Créditos (Izquierda) -->
                <div class="order-2 md:order-1">
                    <p class="text-sm font-light tracking-wide text-gray-500">
                        &copy; 2026 <span class="text-indigo-400 font-medium mx-1 hover:text-indigo-100 transition-colors duration-300">Carlos Codes</span> 
                        <span class="hidden md:inline-block mx-2 text-gray-700">|</span> 
                        <span class="hover:text-indigo-400 transition-colors duration-300">Diseño & Desarrollo</span>
                    </p>
                </div>

                <!-- Botones (Derecha) -->
                <div class="flex flex-wrap items-center justify-center md:justify-end gap-6 order-1 md:order-2">
                    
                    <!-- LinkedIn -->
                    <a href="{{ env('APP_LINKEDIN_URL') }}" target="_blank" class="group">
                        <button type="button" class="footer-btn group-hover:border-[#0077b5] group-hover:text-white">
                            <!-- El componente de icono -->
                            <x-icons.linkedin class="w-5 h-5 transition-colors duration-300" /> 
                            <span class="text-sm font-medium">LinkedIn</span>
                        </button>
                    </a>

                    <!-- GitHub (Ejemplo de cómo seguiría) -->
                    <a href="{{ env('APP_GITHUB_URL') }}" target="_blank" class="group">
                        <button type="button" class="footer-btn group-hover:border-[#3CCF91] group-hover:text-white">
                            <x-icons.github class="w-5 h-5 transition-colors duration-300" />
                            <span class="text-sm font-medium">GitHub</span>
                        </button>
                    </a>

                    <!-- Email -->
                    <a href="mailto:{{ env('APP_CONTACT_EMAIL') }}" class="group">
                        <button type="button" class="footer-btn border-l border-gray-800 pl-6 ml-2 group-hover:text-white">
                            <x-icons.email class="w-5 h-5 transition-colors duration-300" />
                            <span class="text-sm font-medium">Email</span>
                        </button>
                    </a>
                </div>
            </div>
        </footer>

        <!-- BOTÓN SCROLL TO TOP -->
        <div id="scrollToTopBtn" onclick="window.scrollTo({top: 0, behavior: 'smooth'})" 
            class="fixed right-8 z-50 pointer-events-none" 
            style="opacity: 0; transform: translateY(20px); bottom: 32px;">
            
            <div class="h-12 w-12 rounded-full bg-indigo-600 hover:bg-indigo-500 cursor-pointer flex items-center justify-center shadow-lg shadow-indigo-500/30 hover:shadow-indigo-500/50 transition-colors duration-300" role="button" tabindex="0">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" class="text-white">
                    <path d="m18 15-6-6-6 6"></path>
                </svg>
            </div>
        </div>



        <!--
        |--------------------------------------------------------------------------
        | SCRIPTS
        |--------------------------------------------------------------------------
        -->

        <!-- Scroll to Top -->
        <script>
            // 1.Scroll to Top Logic
            const scrollBtn = document.getElementById('scrollToTopBtn');
            window.addEventListener('scroll', () => {
                if (window.scrollY > 300) {
                    scrollBtn.classList.remove('opacity-0', 'pointer-events-none', 'translate-y-10');
                    scrollBtn.classList.add('opacity-100', 'translate-y-0');
                } else {
                    scrollBtn.classList.add('opacity-0', 'pointer-events-none', 'translate-y-10');
                    scrollBtn.classList.remove('opacity-100', 'translate-y-0');
                }
            });

            // 2. Botón scroll to top quede por encima de footer.
            document.addEventListener('DOMContentLoaded', function() {
                const scrollBtn = document.getElementById('scrollToTopBtn');
                const footer = document.getElementById('main-footer');

                if (!scrollBtn || !footer) return;

                const baseBottom = 32; // bottom-8
                let isVisible = false;

                // Aplicamos la transición solo a opacidad y transform desde el inicio
                scrollBtn.style.transition = "opacity 0.4s ease, transform 0.4s ease";

                function updateButton() {
                    const footerRect = footer.getBoundingClientRect();
                    const windowHeight = window.innerHeight;
                    const scrollY = window.scrollY;

                    // 1. Lógica de Visibilidad (Aparecer/Desaparecer)
                    if (scrollY > 300 && !isVisible) {
                        isVisible = true;
                        scrollBtn.style.opacity = "1";
                        scrollBtn.style.pointerEvents = "auto";
                        scrollBtn.style.transform = "translateY(0)";
                    } else if (scrollY <= 300 && isVisible) {
                        isVisible = false;
                        scrollBtn.style.opacity = "0";
                        scrollBtn.style.pointerEvents = "none";
                        scrollBtn.style.transform = "translateY(20px)";
                    }

                    // 2. Lógica de Posición respecto al Footer
                    if (footerRect.top < windowHeight) {
                        // El footer está en pantalla
                        const overlap = windowHeight - footerRect.top;
                        // No usamos transition en 'bottom' para que no haya lag al scrollear
                        scrollBtn.style.bottom = (baseBottom + overlap) + "px";
                    } else {
                        // El footer no está en pantalla
                        scrollBtn.style.bottom = baseBottom + "px";
                    }

                    requestAnimationFrame(updateButton);
                }

                requestAnimationFrame(updateButton);
            }); 
        </script>

        <!-- Seguimiento del ratón (Para efecto sombra tras él) -->
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                // Ahora seleccionamos todas las tarjetas que tengan la clase js-spotlight-card
                const spotlightCards = document.querySelectorAll('.js-spotlight-card, .js-project-card');

                spotlightCards.forEach(card => {
                    card.addEventListener('mousemove', (e) => {
                        const rect = card.getBoundingClientRect();
                        const x = e.clientX - rect.left;
                        const y = e.clientY - rect.top;

                        card.style.setProperty('--mouse-x', `${x}px`);
                        card.style.setProperty('--mouse-y', `${y}px`);
                    });
                });
            });
        </script>

        <!-- Barra de scroll vertical -->
         <script>
            window.addEventListener('scroll', () => {
                const progressBar = document.getElementById('scroll-progress-bar');
                
                // Calcular cuánto se ha scrolleado
                const winScroll = document.body.scrollTop || document.documentElement.scrollTop;
                
                // Calcular la altura total scrolleable (Altura total - Altura ventana)
                const height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
                
                // Convertir a porcentaje
                const scrolled = (winScroll / height) * 100;
                
                // Aplicar el porcentaje a la altura del div
                progressBar.style.height = scrolled + "%";
            });
        </script> 
        
    </body>
</html>
@extends('layouts.public')

@section('content')

    <!-- HERO SECTION -->
    <section id="home" class="relative pt-32 pb-20 bg-white dark:bg-gray-900 overflow-hidden transition-colors duration-300">
        <canvas id="code-canvas" class="absolute top-0 left-0 w-full h-full pointer-events-none opacity-[1] dark:opacity-[1]"></canvas>

        <div class="grid max-w-screen-xl px-4 py-8 mx-auto lg:gap-8 xl:gap-0 lg:py-16 lg:grid-cols-12 items-center">
            
            <div class="w-full text-center lg:text-left place-self-center lg:col-span-7 z-10 order-2 lg:order-1">
                <span class="inline-block py-1 px-3 rounded-full bg-indigo-100 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-300 text-sm font-semibold mb-4 animate-subtle-breath border border-indigo-200 dark:border-indigo-800/50">
                    🚀 Disponible para nuevos proyectos
                </span>
                <h1 class="max-w-2xl mx-auto lg:mx-0 mb-4 text-4xl font-extrabold tracking-tight leading-none md:text-5xl xl:text-6xl text-gray-900 dark:text-white">
                    Hola 👋🏼, soy <br> <span class="text-indigo-600 dark:text-indigo-400">Carlos Codes</span>
                </h1>
                <p class="max-w-2xl mx-auto lg:mx-0 mb-8 font-light text-gray-600 dark:text-gray-400 lg:mb-8 md:text-lg lg:text-xl leading-relaxed">
                    Desarrollador Full Stack web y móvil
                </p>
                
                <div class="flex flex-wrap items-center justify-center lg:justify-start gap-4">
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
            
            <div class="flex justify-center lg:justify-end relative order-1 lg:order-2 lg:col-span-5 mb-10 lg:mb-0">
                <div class="relative w-56 h-56 sm:w-64 sm:h-64 lg:w-80 lg:h-80">
                    <div class="absolute top-0 right-0 w-48 h-48 sm:w-56 sm:h-56 lg:w-72 lg:h-72 bg-indigo-200 dark:bg-indigo-900 rounded-full blur-3xl opacity-40"></div>
                    
                    <div class="relative w-full h-full rounded-full border-4 border-white dark:border-gray-800 shadow-xl overflow-hidden bg-gray-100 dark:bg-gray-800">
                        <img src="{{ asset('img/me-light.png') }}" onerror="this.src='{{ asset('img/logo.png') }}'" alt="Carlos Codes" class="absolute inset-0 w-full h-full object-cover transition-opacity duration-300 opacity-100 dark:opacity-0">
                        <img src="{{ asset('img/me.png') }}" onerror="this.src='{{ asset('img/logo.png') }}'" alt="Carlos Codes" class="absolute inset-0 w-full h-full object-cover transition-opacity duration-300 opacity-0 dark:opacity-100">
                    </div>

                    <div class="absolute bottom-2 left-0 sm:bottom-4 sm:left-0 bg-white dark:bg-gray-800 p-3 rounded-full shadow-lg border border-gray-100 dark:border-gray-700 text-indigo-600 dark:text-indigo-400 animate-floating">
                        <x-icons.laptop class="w-6 h-6 sm:w-8 sm:h-8" />
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- SOBRE MÍ SECTION -->
    <section id="about" class="relative py-24 bg-gray-50 dark:bg-gray-800/30 transition-colors duration-300 overflow-hidden">
        <div class="absolute top-0 right-0 -mr-20 -mt-20 w-72 h-72 bg-indigo-400/10 dark:bg-indigo-600/10 rounded-full blur-3xl pointer-events-none"></div>

        <div class="max-w-screen-xl px-4 mx-auto relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-20 items-center">
                
                <!-- Columna izquierda decorativa -->
                <div class="lg:col-span-5 relative group lg:pr-10"> 
                    <div class="absolute inset-0 bg-gradient-to-tr from-indigo-500 to-blue-500 rounded-2xl transform rotate-3 scale-105 opacity-20 dark:opacity-40 transition-transform duration-500 group-hover:rotate-6"></div>
                    <div class="relative overflow-hidden rounded-2xl shadow-xl transition-transform duration-500 group-hover:-translate-y-2 border border-white/50 dark:border-gray-700 bg-white dark:bg-gray-800 p-2">
                        <div class="overflow-hidden rounded-xl">
                            <img src="{{ asset('img/me-alt.png') }}" onerror="this.src='{{ asset('img/logo.png') }}'" alt="Carlos trabajando" class="w-full h-auto object-cover transform transition-transform duration-700 group-hover:scale-105">
                        </div>
                    </div>

                    <div class="absolute -bottom-6 -right-2 lg:right-4 bg-white dark:bg-gray-900 p-4 rounded-2xl shadow-xl border border-gray-100 dark:border-gray-700 flex items-center gap-4 animate-floating z-20">
                        <div class="bg-indigo-100 dark:bg-indigo-900/50 p-3 rounded-full text-indigo-600 dark:text-indigo-400">
                            <x-icons.cpu class="w-6 h-6" />
                        </div>
                        <div class="whitespace-nowrap">
                            <p class="text-[10px] text-gray-500 dark:text-gray-400 font-semibold uppercase tracking-wider">+7 años de experiencia</p>
                            <p class="text-sm font-bold text-gray-900 dark:text-white">Desarrollando software</p>
                        </div>
                    </div>
                </div>

                <!-- Columna derecha -->
                <div class="lg:col-span-7">
                    <!-- Badge con pulso sutil -->
                    <div class="flex items-center gap-2 mb-4">
                        <span class="relative flex h-3 w-3">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-3 w-3 bg-indigo-500"></span>
                        </span>
                        <span class="text-indigo-600 dark:text-indigo-400 font-bold tracking-widest uppercase text-xs">
                            Conoce mi perfil
                        </span>
                    </div>
    
                                    
                    <h2 class="text-3xl md:text-4xl lg:text-5xl font-extrabold text-gray-900 dark:text-white mb-6 leading-[1.15]">
                        Diseñando y programando apps y webs con la mejor <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-blue-500 dark:from-indigo-400 dark:to-blue-400">arquitectura de software.</span>
                    </h2>

                    <div class="space-y-4 text-base md:text-lg text-gray-600 dark:text-gray-300 leading-relaxed mb-8">
                        <p>Empecé como profesional en el sector electrónico aeroespacial, un entorno <strong>científico y metódico</strong>.</p>
                        <p>Con el tiempo decidí licenciarme como programador web y de aplicaciones y actualmente llevo <strong>más de 7 años</strong> combinando una metodología científica y mi visión creativa para construir proyectos modernos y óptimos para particulares y empresas.</p>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-10">
                        <div class="flex items-center gap-3 bg-white dark:bg-gray-800/50 p-4 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700">
                            <div class="text-indigo-500"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"></path></svg></div>
                            <span class="font-medium text-gray-800 dark:text-gray-200">Sistemas ERP/CRM</span>
                        </div>
                        <div class="flex items-center gap-3 bg-white dark:bg-gray-800/50 p-4 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700">
                            <div class="text-indigo-500"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg></div>
                            <span class="font-medium text-gray-800 dark:text-gray-200">Compose Multiplatform</span>
                        </div>
                    </div>

                    <a href="{{ route('public.about') }}" class="group inline-flex items-center justify-center px-6 py-3.5 text-base font-semibold text-white bg-gray-900 hover:bg-gray-800 dark:bg-indigo-600 dark:hover:bg-indigo-700 rounded-lg transition-all shadow-md hover:shadow-lg">
                        Conoce mi historia completa
                        <svg class="w-5 h-5 ml-2 transition-transform duration-300 group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </a>
                </div>

            </div>
        </div>
    </section>

    <!-- SKILLS SECTION -->
    <section id="skills" x-data="skillsComponent()" class="py-20 bg-gray-50 dark:bg-gray-800 border-y border-gray-100 dark:border-gray-700 transition-colors duration-300">
        <div class="max-w-screen-xl px-4 mx-auto relative">
            <div class="mb-12">
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white">Stack Tecnológico</h2>
                <div class="w-20 h-1.5 bg-indigo-600 mt-4 rounded-full"></div>
                <p class="text-gray-600 dark:text-gray-300 max-w-4xl mt-4 text-lg leading-relaxed">
                    Trato con una gran gama de tecnologías pues he trabajado desde webs dinámicas (Desde portfolios hasta CRMs, ERPs y CMS) hasta aplicaciones móviles y multiplataforma en completo fullstack.
                </p>
            </div>
            
            <!-- Grid Principal (6 Tarjetas) -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <template x-for="(skill, key) in skillsData" :key="key">
                    <div @click="openModal(key)" class="skill-card js-spotlight-card group cursor-pointer bg-white dark:bg-gray-900 rounded-2xl p-6 shadow-sm border border-gray-200 dark:border-gray-700 transition-all duration-300 hover:shadow-lg hover:border-indigo-400 dark:hover:border-indigo-500 hover:-translate-y-1 flex flex-col h-full relative overflow-hidden">
                        <div class="flex items-center gap-4 mb-5 relative z-10">
                            <div :class="`p-3 rounded-xl ${skill.bg} ${skill.color} transition-transform group-hover:scale-110`">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" :d="skill.icon"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white leading-tight" x-text="skill.title"></h3>
                        </div>
                        
                        <div class="flex flex-wrap gap-2 mt-auto relative z-10">
                            <template x-for="(tech, index) in skill.technologies.slice(0, 4)" :key="index">
                                <img :src="tech.badge" :alt="tech.name" class="h-6 rounded shadow-sm">
                            </template>
                            <span x-show="skill.technologies.length > 4" class="flex items-center px-2 py-1 text-xs font-bold text-gray-500 dark:text-gray-400 bg-gray-100 dark:bg-gray-800 rounded" x-text="`+${skill.technologies.length - 4}`"></span>
                        </div>

                        <div class="mt-5 pt-4 border-t border-gray-100 dark:border-gray-800 flex justify-between items-center text-sm font-medium text-indigo-600 dark:text-indigo-400 opacity-0 group-hover:opacity-100 transition-opacity relative z-10">
                            Ver detalle de tecnologías
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </div>
                    </div>
                </template>
            </div>
        </div>

        <!-- MODAL OVERLAY -->
        <div x-show="modalOpen" style="display: none;" class="fixed inset-0 z-[100] overflow-y-auto">
            
            <!-- Fondo Oscuro -->
            <div x-show="modalOpen" x-transition.opacity.duration.300ms @click="closeModal()" class="fixed inset-0 bg-gray-900/70 backdrop-blur-sm min-h-screen"></div>

            <!-- Contenedor Flex -->
            <div class="relative min-h-screen flex flex-col md:flex-row items-center justify-center p-4 md:p-8 overflow-hidden pointer-events-none">
                
                <!-- TARJETA PRINCIPAL (Izquierda - Z-INDEX ALTO) -->
                <!-- 'relative z-20' para que tape a la otra card al salir -->
                <div x-show="modalOpen" 
                    x-transition:enter="ease-out duration-500" 
                    x-transition:enter-start="opacity-0 translate-y-8 sm:scale-95" 
                    x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" 
                    x-transition:leave="ease-in duration-300" 
                    x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" 
                    x-transition:leave-end="opacity-0 translate-y-8 sm:scale-95" 
                    class="relative z-20 bg-white dark:bg-gray-900 rounded-2xl shadow-2xl w-full max-w-xl border border-gray-200 dark:border-gray-700 overflow-hidden transition-all duration-500 pointer-events-auto">
                    
                    <div class="px-6 py-5 border-b border-gray-100 dark:border-gray-800 flex justify-between items-center bg-gray-50/50 dark:bg-gray-800/50">
                        <div class="flex items-center gap-3">
                            <div x-if="activeSkill" :class="`p-2 rounded-lg ${activeSkill?.bg} ${activeSkill?.color}`">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" :d="activeSkill?.icon"></path></svg>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white" x-text="activeSkill?.title"></h3>
                        </div>
                        <button @click="closeModal()" class="text-gray-400 hover:text-gray-900 dark:hover:text-white transition-colors">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>

                    <div class="px-6 py-6">
                        <p class="text-gray-600 dark:text-gray-300 text-sm mb-6 bg-gray-50 dark:bg-gray-800/50 p-4 rounded-xl" x-html="activeSkill?.description"></p>
                        
                        <h4 class="text-xs font-bold tracking-wider uppercase text-gray-500 dark:text-gray-400 mb-4 flex items-center gap-2">
                            Haz clic en una tecnología
                            <svg class="w-4 h-4 text-indigo-500 animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122"></path></svg>
                        </h4>
                        
                        <div class="flex flex-wrap gap-3 mb-2">
                            <template x-for="(tech, index) in activeSkill?.technologies" :key="index">
                                <img :src="tech.badge" :alt="tech.name" 
                                    @click="openTech(tech)"
                                    class="h-8 rounded shadow-sm transition-all duration-300 cursor-pointer ring-offset-2 dark:ring-offset-gray-900"
                                    :class="activeTech === tech ? 'ring-2 ring-indigo-500 scale-105 opacity-100' : 'hover:scale-105 opacity-80 hover:opacity-100 grayscale-[20%] hover:grayscale-0'">
                            </template>
                        </div>
                    </div>
                </div>

                <!-- TARJETA DE DETALLE (Z-INDEX BAJO) -->
                <!-- Poner '!' da prioridad a la animación y los márgenes negativos fuerzan a la tarjeta a esconderse detrás -->
                <div x-show="showTechDetails"
                    x-transition:enter="transition-all duration-500 cubic-bezier(0.4, 0, 0.2, 1)"
                    x-transition:enter-start="opacity-0 !-mt-[20rem] md:!mt-0 md:!-ml-[24rem] scale-95"
                    x-transition:enter-end="opacity-100 mt-4 md:mt-0 md:ml-6 scale-100"
                    x-transition:leave="transition-all duration-300 ease-in"
                    x-transition:leave-start="opacity-100 mt-4 md:mt-0 md:ml-6 scale-100"
                    x-transition:leave-end="opacity-0 !-mt-[20rem] md:!mt-0 md:!-ml-[24rem] scale-95"
                    class="relative z-10 w-full max-w-sm bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-indigo-100 dark:border-gray-700 pointer-events-auto mt-4 md:mt-0 md:ml-6">
                    
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-4">
                            <img :src="activeTech?.badge" :alt="activeTech?.name" class="h-8 rounded shadow-sm">
                            <button @click="closeTech()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 bg-gray-100 dark:bg-gray-700 p-1 rounded-full transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </button>
                        </div>
                        
                        <h4 class="text-lg font-extrabold text-gray-900 dark:text-white mb-2">Mi experiencia</h4>
                        <p class="text-gray-600 dark:text-gray-300 text-sm leading-relaxed" x-text="activeTech?.description"></p>
                    </div>
                    
                    <!-- Decoración -->
                    <div class="absolute bottom-0 right-0 p-4 opacity-5 pointer-events-none">
                        <svg class="w-24 h-24" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/></svg>
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

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($projects->take(3) as $project)
                    <article class="project-card js-project-card bg-gray-50 dark:bg-gray-800/50 rounded-2xl overflow-hidden border border-gray-200 dark:border-gray-700 flex flex-col h-full shadow-sm">
                        <div class="relative aspect-video overflow-hidden bg-gray-100 dark:bg-gray-800 flex items-center justify-center">
                            @if($project->image_url)
                                <img src="{{ asset($project->image_url) }}" class="w-full h-full object-cover">
                            @else
                                <img src="{{ asset('img/logo.png') }}" class="w-16 h-16">
                            @endif
                        </div>

                        <div class="p-6 flex-grow flex flex-col relative z-10">
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">{{ $project->title }}</h3>
                            <p class="text-gray-600 dark:text-gray-400 text-sm mb-6 flex-grow leading-relaxed">{{ $project->description }}</p>

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

            <div class="mt-16 text-center">
                <a href="/proyectos" class="group inline-flex items-center gap-3 px-8 py-2 rounded-xl border border-gray-300 dark:border-gray-700 text-gray-700 dark:text-gray-300 font-bold text-sm tracking-wide transition-all duration-200 hover:scale-105 hover:bg-indigo-600 hover:text-white hover:border-indigo-600 hover:shadow-indigo-500/30">
                    Ver más proyectos 
                    <span class="text-indigo-600 dark:text-indigo-400 font-mono text-lg transition-transform duration-300 group-hover:text-white group-hover:translate-x-1">&lt;&gt;</span>
                </a>
            </div>
        </div>
    </section>


    <!-- SECCIÓN DE CONTACTO -->
    <section id="contact" class="py-20 bg-gray-50 dark:bg-gray-800 border-t border-gray-100 dark:border-gray-700 transition-colors duration-300">
        <div class="max-w-screen-md mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white">¿Trabajamos juntos?</h2>
                <div class="w-32 h-1.5 bg-indigo-600 mt-4 rounded-full mx-auto"></div>
                
                @if (session('status'))
                    <div class="mt-4 p-4 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300 rounded-lg border border-green-200 dark:border-green-800">
                        {{ session('status') }}
                    </div>
                @else
                    <p class="mt-4 text-gray-500 dark:text-gray-400">Envíame un mensaje y te responderé lo antes posible.</p>
                @endif
            </div>

            <div class="bg-white dark:bg-gray-900 p-8 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
                <form id="contactForm" action="{{ route('contact.store') }}" method="POST" class="space-y-6">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nombre</label>
                            <input type="text" name="name" value="{{ old('name') }}" required class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 transition-colors">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Email</label>
                            <input type="email" name="email" value="{{ old('email') }}" required class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 transition-colors">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Mensaje</label>
                        <textarea name="content" rows="4" required class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 transition-colors">{{ old('content') }}</textarea>
                    </div>
                    
                    <div class="pt-4">
                        <button type="submit" class="w-full px-6 py-3 bg-indigo-600 text-white font-medium rounded-lg hover:bg-indigo-700 transition shadow-lg shadow-indigo-500/30">
                            Enviar Mensaje
                        </button>
                    </div>
                </form>
                <div class="mt-5 text-center">
                    <span class="text-sm text-gray-400 mb-3"> O si lo prefieres: </span>
                    <a href="mailto:{{ env('APP_CONTACT_EMAIL') }}" class="inline-flex items-center gap-2 px-4 py-2 text-sm bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 text-gray-600 dark:text-gray-400 rounded-md hover:bg-gray-50 dark:hover:bg-gray-700 transition opacity-80 hover:opacity-100">
                        <svg class="w-4 h-4 text-red-500" fill="currentColor" viewBox="0 0 24 24"><path d="M24 5.457v13.909c0 .904-.732 1.636-1.636 1.636h-3.819V11.73L12 16.64l-6.545-4.91v9.273H1.636A1.636 1.636 0 0 1 0 19.366V5.457c0-2.023 2.309-3.178 3.927-1.964L5.455 4.64 12 9.548l6.545-4.91 1.528-1.145C21.69 2.28 24 3.434 24 5.457z"/></svg>
                        Contactar por email
                    </a>
                </div>
            </div>
        </div>
    </section>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('contactForm');
        
        if (form) {
            form.addEventListener('submit', async function(e) {
                e.preventDefault();
                
                const submitBtn = form.querySelector('button[type="submit"]');
                const originalBtnText = submitBtn.innerHTML;
                
                form.querySelectorAll('.error-msg, .server-error-banner').forEach(el => el.remove());
                form.querySelectorAll('.border-red-500').forEach(el => el.classList.remove('border-red-500', 'focus:border-red-500', 'focus:ring-red-500'));

                submitBtn.disabled = true;
                submitBtn.innerHTML = `
                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white inline-block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Enviando...
                `;

                try {
                    const formData = new FormData(form);
                    const response = await fetch(form.action, {
                        method: 'POST',
                        body: formData,
                        headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
                    });

                    const contentType = response.headers.get("content-type");
                    if (contentType && contentType.indexOf("application/json") !== -1) {
                        const data = await response.json();

                        if (!response.ok) {
                            if (response.status === 422) {
                                for (const [field, errors] of Object.entries(data.errors)) {
                                    const input = form.querySelector(`[name="${field}"]`);
                                    if (input) {
                                        input.classList.add('border-red-500', 'focus:border-red-500', 'focus:ring-red-500');
                                        const errorDiv = document.createElement('p');
                                        errorDiv.className = 'error-msg mt-1 text-sm text-red-600 dark:text-red-400 animate-pulse';
                                        errorDiv.innerText = errors[0];
                                        input.parentNode.appendChild(errorDiv);
                                    } else {
                                        mostrarError(form, `Error en el campo backend "${field}": ${errors[0]}`);
                                    }
                                }
                            } else {
                                mostrarError(form, data.message || 'Error desconocido del servidor.');
                            }
                        } else {
                            const successCard = `
                                <div class="flex flex-col items-center justify-center p-8 text-center bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800/50 rounded-2xl transition-all duration-500">
                                    <div class="w-16 h-16 bg-green-100 dark:bg-green-800/50 rounded-full flex items-center justify-center mb-6 shadow-sm shadow-green-500/20">
                                        <svg class="w-8 h-8 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    </div>
                                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">¡Mensaje Enviado!</h3>
                                    <p class="text-gray-600 dark:text-gray-300">${data.message}</p>
                                </div>
                            `;
                            form.parentElement.innerHTML = successCard;
                        }
                    } else {
                        mostrarError(form, 'Fallo interno del servidor (Error 500).');
                    }
                } catch (error) {
                    mostrarError(form, 'Error de conexión. Revisa tu internet e inténtalo de nuevo.');
                } finally {
                    if (document.body.contains(submitBtn)) {
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = originalBtnText;
                    }
                }
            });

            function mostrarError(formulario, mensaje) {
                const errorBanner = document.createElement('div');
                errorBanner.className = 'server-error-banner p-4 mb-6 text-sm text-red-700 bg-red-100 rounded-xl dark:bg-red-900/30 dark:text-red-400 border border-red-200 dark:border-red-800/50';
                errorBanner.innerHTML = `<strong>Algo salió mal:</strong> ${mensaje}`;
                formulario.prepend(errorBanner);
            }
        }
    });
</script>

<!-- Tarjetas skills técnicas -->
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('skillsComponent', () => ({
        modalOpen: false,
        activeSkill: null,
        activeTech: null,
        showTechDetails: false,
        
        skillsData: {
            web: {
                title: 'Desarrollo Web & Frameworks',
                icon: 'M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9',
                color: 'text-indigo-600 dark:text-indigo-400',
                bg: 'bg-indigo-50 dark:bg-indigo-900/30',
                description: 'Mi núcleo de trabajo diario. Construyo plataformas robustas y escalables dominando tanto el ciclo backend como el renderizado frontend.',
                technologies:[
                    { name: 'Laravel', badge: 'https://img.shields.io/badge/Laravel-FF2D20?style=flat&logo=laravel&logoColor=white', description: 'Framework principal para el backend. Desarrollo de APIs REST complejas, autenticación segura, middlewares, colas de trabajo y lógica de negocio mediante Eloquent ORM.' },
                    { name: 'PHP', badge: 'https://img.shields.io/badge/PHP-777BB4?style=flat&logo=php&logoColor=white', description: 'Lenguaje base de mi stack backend. Escritura de código limpio, fuertemente tipado en sus últimas versiones y enfocado en Programación Orientada a Objetos.' },
                    { name: 'JavaScript', badge: 'https://img.shields.io/badge/JavaScript-F7DF1E?style=flat&logo=javascript&logoColor=black', description: 'Creación de interactividad en el frontend, consumo asíncrono de APIs (Fetch/Axios) y manipulación avanzada del DOM en Vanilla JS.' },
                    { name: 'Tailwind CSS', badge: 'https://img.shields.io/badge/Tailwind_CSS-38B2AC?style=flat&logo=tailwind-css&logoColor=white', description: 'Mi framework CSS de cabecera. Lo aplico para maquetar interfaces modernas, 100% responsivas y altamente personalizadas sin abandonar el HTML.' },
                    { name: 'HTML5', badge: 'https://img.shields.io/badge/HTML5-E34F26?style=flat&logo=html5&logoColor=white', description: 'Creación de estructuras semánticas y accesibles, garantizando un buen SEO técnico y compatibilidad cross-browser.' },
                    { name: 'CSS3', badge: 'https://img.shields.io/badge/CSS3-1572B6?style=flat&logo=css3&logoColor=white', description: 'Aplicación de estilos nativos, variables CSS, animaciones complejas y layouts modernos con Flexbox y CSS Grid.' },
                    { name: 'jQuery', badge: 'https://img.shields.io/badge/jQuery-0769AD?style=flat&logo=jquery&logoColor=white', description: 'Mantenimiento y refactorización de proyectos heredados, así como creación de scripts rápidos para validaciones en el lado del cliente.' },
                    { name: 'Bootstrap', badge: 'https://img.shields.io/badge/Bootstrap-7952B3?style=flat&logo=bootstrap&logoColor=white', description: 'Uso en proyectos corporativos o sistemas de gestión (dashboards) donde se requiere un prototipado UI estable e inmediato.' }
                ]
            },
            movil: {
                title: 'Desarrollo Multiplataforma & Móvil',
                icon: 'M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z',
                color: 'text-green-600 dark:text-green-400',
                bg: 'bg-green-50 dark:bg-green-900/30',
                description: 'Creación de ecosistemas de software interactivos. Desde aplicaciones móviles nativas conectadas a mis propios backends, hasta lógicas de alto rendimiento.',
                technologies:[
                    { name: 'Kotlin', badge: 'https://img.shields.io/badge/Kotlin-7F52FF?style=flat&logo=kotlin&logoColor=white', description: 'Desarrollo de aplicaciones nativas para el ecosistema Android. Manejo de corrutinas, inyección de dependencias e integración con APIs REST.' },
                    { name: 'Android Studio', badge: 'https://img.shields.io/badge/Android%20Studio-3DDC84?style=flat&logo=android-studio&logoColor=white', description: 'Entorno de desarrollo principal para el ciclo de vida completo de la app: perfilado de memoria, diseño XML/Compose y compilación para producción.' },
                    { name: 'C++', badge: 'https://img.shields.io/badge/C++-00599C?style=flat&logo=c%2B%2B&logoColor=white', description: 'Vengo de diseñar hardware y software crítico. El uso de C++ forjó mis bases en la gestión estricta de memoria, punteros y eficiencia a bajo nivel.' },
                    { name: 'C#', badge: 'https://img.shields.io/badge/C%23-239120?style=flat&logo=csharp&logoColor=white', description: 'Creación de lógicas complejas, scripting y herramientas orientadas a objetos, principalmente aplicadas dentro de ecosistemas como Unity o backend corporativo.' },
                    { name: 'Unity', badge: 'https://img.shields.io/badge/Unity-100000?style=flat&logo=unity&logoColor=white', description: 'Desarrollo de entornos interactivos, físicas y UI avanzadas, gestionando los patrones de diseño específicos para el desarrollo de videojuegos y simulaciones.' }
                ]
            },
            ecommerce: {
                title: 'E-commerce, ERPs & CMS',
                icon: 'M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z',
                color: 'text-pink-600 dark:text-pink-400',
                bg: 'bg-pink-50 dark:bg-pink-900/30',
                description: 'Digitalización de negocios. Implemento tiendas online y las integro con sistemas de facturación para automatizar los flujos empresariales.',
                technologies:[
                    { name: 'PrestaShop', badge: 'https://img.shields.io/badge/PrestaShop-df0067?style=flat&logo=prestashop&logoColor=white', description: 'Creación y configuración de tiendas B2C/B2B avanzadas. Desarrollo de módulos a medida en PHP, overrides y adaptación de plantillas Smarty.' },
                    { name: 'Dolibarr ERP', badge: 'https://img.shields.io/badge/Dolibarr_ERP-2980B9?style=flat', description: 'Implantación del sistema para control de facturación, stock y clientes (CRM). Programación de integraciones por API para sincronizarlo con tiendas web.' },
                    { name: 'WooCommerce', badge: 'https://img.shields.io/badge/WooCommerce-96588A?style=flat&logo=woocommerce&logoColor=white', description: 'Desarrollo e-commerce sobre ecosistema WordPress. Modificación de hooks, creación de pasarelas de pago y adaptación de flujos de carrito.' },
                    { name: 'WordPress', badge: 'https://img.shields.io/badge/WordPress-21759B?style=flat&logo=wordpress&logoColor=white', description: 'Construcción de webs corporativas y catálogos autogestionables, securización del CMS y creación de Custom Post Types y lógicas a medida.' }
                ]
            },
            bbdd: {
                title: 'Bases de Datos (SGBD)',
                icon: 'M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4',
                color: 'text-blue-600 dark:text-blue-400',
                bg: 'bg-blue-50 dark:bg-blue-900/30',
                description: 'Diseño estructuras de datos asegurando integridad relacional y eficiencia en consultas complejas para sostener la lógica de negocio.',
                technologies:[
                    { name: 'MySQL', badge: 'https://img.shields.io/badge/MySQL-4479A1?style=flat&logo=mysql&logoColor=white', description: 'Motor relacional principal para webs. Diseño esquemas normalizados, optimizo índices y escribo consultas crudas complejas para reportes.' },
                    { name: 'MariaDB', badge: 'https://img.shields.io/badge/MariaDB-003545?style=flat&logo=mariadb&logoColor=white', description: 'Despliegue como alternativa OpenSource de alto rendimiento a MySQL en servidores Linux (VPS), garantizando la seguridad de los datos.' },
                    { name: 'Firebase', badge: 'https://img.shields.io/badge/Firebase-FFCA28?style=flat&logo=firebase&logoColor=black', description: 'Uso de Bases de Datos NoSQL en Tiempo Real y Firestore, además de implementar sus servicios de autenticación y notificaciones Push en apps.' },
                    { name: 'SQLite', badge: 'https://img.shields.io/badge/SQLite-003B57?style=flat&logo=sqlite&logoColor=white', description: 'Base de datos ligera elegida para almacenamiento persistente local en aplicaciones Android y entornos de testing en Laravel.' },
                    { name: 'phpMyAdmin', badge: 'https://img.shields.io/badge/phpMyAdmin-6C78AF?style=flat', description: 'Gestión visual en entornos de hosting compartido, exportación de volcados y administración de privilegios de usuario.' },
                    { name: 'HeidiSQL', badge: 'https://img.shields.io/badge/HeidiSQL-FFD43B?style=flat', description: 'Mi cliente SQL preferido para conectar remotamente a bases de datos en producción y realizar mantenimientos o scripts de migración masiva.' }
                ]
            },
            infra: {
                title: 'Infraestructura & DevOps',
                icon: 'M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2',
                color: 'text-orange-600 dark:text-orange-400',
                bg: 'bg-orange-50 dark:bg-orange-900/30',
                description: 'No solo escribo código, también lo pongo en producción. Gestiono los servidores, el control de versiones y el ciclo de testing.',
                technologies:[
                    { name: 'Docker', badge: 'https://img.shields.io/badge/Docker-2496ED?style=flat&logo=docker&logoColor=white', description: 'Containerización de entornos (Sail en Laravel) para garantizar que el software funcione idéntico en desarrollo, staging y producción.' },
                    { name: 'Nginx', badge: 'https://img.shields.io/badge/Nginx-009639?style=flat&logo=nginx&logoColor=white', description: 'Configuración como proxy inverso y servidor web de alto rendimiento en entornos VPS para servir aplicaciones Laravel y Node.' },
                    { name: 'Apache', badge: 'https://img.shields.io/badge/Apache-D22128?style=flat&logo=apache&logoColor=white', description: 'Gestión de servidores web tradicionales, control de reglas de reescritura en archivos .htaccess y gestión de certificados SSL.' },
                    { name: 'Git', badge: 'https://img.shields.io/badge/Git-F05032?style=flat&logo=git&logoColor=white', description: 'Uso avanzado del control de versiones: ramificaciones estructuradas (GitFlow), resolución de conflictos y rebase.' },
                    { name: 'GitHub', badge: 'https://img.shields.io/badge/GitHub-181717?style=flat&logo=github&logoColor=white', description: 'Alojamiento de repositorios, trabajo colaborativo en equipos, code reviews y automatización de acciones CI/CD.' },
                    { name: 'Postman', badge: 'https://img.shields.io/badge/Postman-FF6C37?style=flat&logo=postman&logoColor=white', description: 'Herramienta vital para documentar y probar rigurosamente todos los endpoints de las APIs REST antes de implementarlas en el frontend.' },
                    { name: 'Bash', badge: 'https://img.shields.io/badge/Terminal/Bash-4EAA25?style=flat&logo=gnu-bash&logoColor=white', description: 'Dominio de la terminal Linux para administración de servidores por SSH y creación de scripts automatizados de backups.' },
                    { name: 'FileZilla', badge: 'https://img.shields.io/badge/FileZilla-BF0000?style=flat&logo=filezilla&logoColor=white', description: 'Transferencia segura de archivos vía SFTP para despliegues manuales en entornos de hosting convencionales.' }
                ]
            },
            arquitectura: {
                title: 'Arquitectura y Patrones',
                icon: 'M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
                color: 'text-purple-600 dark:text-purple-400',
                bg: 'bg-purple-50 dark:bg-purple-900/30',
                description: 'La diferencia entre un código que "funciona" y uno "profesional". Aplico principios de ingeniería para crear software escalable y libre de deuda técnica.',
                technologies:[
                    { name: 'Clean Architecture', badge: 'https://img.shields.io/badge/Clean_Architecture-607D8B?style=flat', description: 'Separación estricta del código en capas (Dominio, Casos de Uso, Infraestructura). Permite cambiar la base de datos o el framework sin afectar la lógica del negocio.' },
                    { name: 'SOLID Principles', badge: 'https://img.shields.io/badge/SOLID_Principles-607D8B?style=flat', description: 'Aplicación constante de los 5 principios. Diseño clases con responsabilidad única, inyección de dependencias e interfaces claras para código altamente testeable.' },
                    { name: 'Design Patterns', badge: 'https://img.shields.io/badge/Design_Patterns-607D8B?style=flat', description: 'Implementación de soluciones probadas: Singleton para conexiones, Factory para creación de objetos, Repository para abstracción de datos o Observer para eventos.' },
                    { name: 'MVVM', badge: 'https://img.shields.io/badge/MVVM-607D8B?style=flat', description: 'Patrón Modelo-Vista-ViewModel, indispensable en mis desarrollos móviles e interfaces reactivas modernas para separar la UI de la lógica de estado.' },
                    { name: 'REST APIs', badge: 'https://img.shields.io/badge/REST_APIs-607D8B?style=flat', description: 'Diseño de arquitecturas sin estado. Implemento verbos HTTP correctos, códigos de estado semánticos, tokens JWT y endpoints altamente predecibles.' }
                ]
            }
        },
        
        openModal(skillKey) {
            this.activeSkill = this.skillsData[skillKey];
            this.showTechDetails = false;
            this.activeTech = null;
            this.modalOpen = true;
            document.body.classList.add('overflow-hidden');
        },
        closeModal() {
            this.modalOpen = false;
            this.showTechDetails = false;
            setTimeout(() => {
                this.activeSkill = null;
                this.activeTech = null;
            }, 500); // Espera a que termine la animación css
            document.body.classList.remove('overflow-hidden');
        },
        openTech(tech) {
            // Si hace click en la misma que ya está abierta, la cierra
            if (this.activeTech === tech) {
                this.closeTech();
            } else {
                this.activeTech = tech;
                this.showTechDetails = true;
            }
        },
        closeTech() {
            this.showTechDetails = false;
            setTimeout(() => this.activeTech = null, 400);
        }
    }))
})
</script>
@endpush
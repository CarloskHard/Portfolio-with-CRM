{{-- Tarjeta de proyecto --}}
@props(['project'])

<article class="group project-card js-project-card bg-gray-50 dark:bg-gray-800 rounded-2xl overflow-hidden border border-gray-200 dark:border-gray-700 flex flex-col h-full shadow-sm 
    hover:shadow-2xl hover:shadow-indigo-500/10 hover:-translate-y-2 hover:border-indigo-500/50 transition-all duration-300 relative">
    
    {{-- Detalle moderno: Línea de acento superior que se expande --}}
    <div class="absolute top-0 left-0 w-0 h-1 bg-indigo-600 group-hover:w-full transition-all duration-500 z-30"></div>

    @php
        $images = $project->images ?? [];
        if (empty($images) && !empty($project->image_url)) {
            $images = [$project->image_url];
        }
    @endphp

    <!-- LLAMADA AL COMPONENTE CARRUSEL -->
    <div class="relative overflow-hidden">
        <x-carousel :images="$images" />
    </div>

    <!-- Contenido -->
    <div class="p-6 flex-grow flex flex-col relative z-10">
        {{-- El título cambia de color cuando la tarjeta recibe hover --}}
        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors duration-300">
            {{ $project->title }}
        </h3>
        
        <p class="text-gray-600 dark:text-gray-400 text-sm mb-6 flex-grow leading-relaxed">
            {{ $project->description }}
        </p>

        <!-- BOTONES DE GITHUB Y DEMO -->
        <div class="flex flex-wrap gap-3 mt-auto pt-5 border-t border-gray-100 dark:border-gray-700/50">
            
            @if($project->url_repo)
                <!-- Botón GitHub -->
                <a href="{{ $project->url_repo }}" target="_blank" 
                class="group/repo relative inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-bold uppercase tracking-wide text-indigo-600 dark:text-indigo-400 border border-indigo-100 dark:border-indigo-500/30 overflow-hidden transition-all duration-300 hover:shadow-lg hover:shadow-indigo-500/20 hover:border-indigo-600 dark:hover:border-indigo-400">
                    
                    {{-- Capa de fondo animada (Entra desde la izquierda) --}}
                    <span class="absolute inset-0 w-full h-full bg-indigo-600 dark:bg-indigo-500 -translate-x-full group-hover/repo:translate-x-0 transition-transform duration-300 ease-out z-0"></span>

                    {{-- Icono --}}
                    <x-icons.github class="relative z-10 w-4 h-4 transition-all duration-300 group-hover/repo:text-white group-hover/repo:rotate-12 group-hover/repo:scale-110" />
                    
                    {{-- Texto --}}
                    <span class="relative z-10 transition-colors duration-300 group-hover/repo:text-white">
                        GitHub
                    </span>
                </a>
            @endif

            @if($project->url_demo)
                <!-- Botón Demo -->
                <a href="{{ $project->url_demo }}" target="_blank" 
                class="group/demo relative inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-bold uppercase tracking-wide text-gray-700 dark:text-gray-300 border border-gray-200 dark:border-gray-700 overflow-hidden transition-all duration-300 hover:shadow-lg hover:shadow-gray-900/10 dark:hover:shadow-white/10 hover:border-gray-900 dark:hover:border-white">
                    
                    {{-- Capa de fondo animada (Entra desde la izquierda) --}}
                    <span class="absolute inset-0 w-full h-full bg-gray-900 dark:bg-white -translate-x-full group-hover/demo:translate-x-0 transition-transform duration-300 ease-out z-0"></span>

                    {{-- Icono --}}
                    <x-icons.eye class="relative z-10 w-4 h-4 transition-all duration-300 group-hover/demo:text-white dark:group-hover/demo:text-gray-900 group-hover/demo:scale-110" />
                    
                    {{-- Texto --}}
                    <span class="relative z-10 transition-colors duration-300 group-hover/demo:text-white dark:group-hover/demo:text-gray-900">
                        Demo
                    </span>
                </a>
            @endif
        </div>
    </div>

    {{-- Efecto de resplandor sutil al fondo --}}
    <div class="absolute -bottom-24 -right-24 w-48 h-48 bg-indigo-500/5 rounded-full blur-3xl group-hover:bg-indigo-500/10 transition-colors duration-500"></div>
</article>
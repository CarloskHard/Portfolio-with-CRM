{{-- Carrusel de imágenes --}}
<!-- En vez de usar JS uso Alpine para que todo lo que el carrusel necesita esté en este archivo y olvidarnos de enlazar archivo js. Además simplifica la lógica. -->

@props([
    'images' => [],
    'fallback' => asset('img/logo.png')
])

<div x-data="{ 
        currentIndex: 0, 
        total: {{ count($images) }},
        next() { if (this.currentIndex < this.total - 1) this.currentIndex++ },
        prev() { if (this.currentIndex > 0) this.currentIndex-- }
     }" 
     class="relative aspect-video overflow-hidden bg-gray-100 dark:bg-gray-800 flex items-center justify-center group">
    
    @if(count($images) > 0)
        <!-- Track -->
        <div class="flex w-full h-full transition-transform duration-500 ease-in-out"
             :style="'transform: translateX(-' + (currentIndex * 100) + '%)'">
            @foreach($images as $img)
                <div class="w-full h-full flex-shrink-0">
                    <img src="{{ asset($img) }}" class="w-full h-full object-cover" alt="Imagen del carrusel">
                </div>
            @endforeach
        </div>

        @if(count($images) > 1)
            <!-- Botón Izquierda -->
            <button @click.prevent.stop="prev()" 
                    x-show="currentIndex > 0"
                    class="absolute left-2 top-1/2 -translate-y-1/2 bg-black/50 hover:bg-black/70 text-white p-2 rounded-full opacity-0 group-hover:opacity-100 transition-opacity z-20">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            </button>
            
            <!-- Botón Derecha -->
            <button @click.prevent.stop="next()" 
                    x-show="currentIndex < total - 1"
                    class="absolute right-2 top-1/2 -translate-y-1/2 bg-black/50 hover:bg-black/70 text-white p-2 rounded-full opacity-0 group-hover:opacity-100 transition-opacity z-20">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            </button>
            
            <!-- Contador -->
            <div class="absolute bottom-2 right-2 bg-black/60 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity z-20">
                <span x-text="currentIndex + 1"></span> / {{ count($images) }}
            </div>
        @endif
    @else
        <img src="{{ $fallback }}" class="w-16 h-16 opacity-50">
    @endif
</div>
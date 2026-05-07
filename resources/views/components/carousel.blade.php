{{-- Carrusel de imágenes --}}
<!-- En vez de usar JS uso Alpine para que todo lo que el carrusel necesita esté en este archivo y olvidarnos de enlazar archivo js. Además simplifica la lógica. -->

@props([
    'images' => [],
    'fallback' => asset('img/logo.svg')
])

<div x-data="{
        currentIndex: 0,
        total: {{ count($images) }},
        hasMultiple: {{ count($images) > 1 ? 'true' : 'false' }},
        autoplayMs: 3500,
        autoplayTimer: null,
        next() {
            if (!this.hasMultiple) return;
            this.currentIndex = (this.currentIndex + 1) % this.total;
        },
        prev() {
            if (!this.hasMultiple) return;
            this.currentIndex = (this.currentIndex - 1 + this.total) % this.total;
        },
        startAutoplay() {
            if (!this.hasMultiple) return;
            this.stopAutoplay();
            this.autoplayTimer = setInterval(() => this.next(), this.autoplayMs);
        },
        stopAutoplay() {
            if (this.autoplayTimer) {
                clearInterval(this.autoplayTimer);
                this.autoplayTimer = null;
            }
        },
        pauseAutoplay() { this.stopAutoplay(); },
        resumeAutoplay() { this.startAutoplay(); }
     }"
     x-init="startAutoplay()"
     @mouseenter="pauseAutoplay()"
     @mouseleave="resumeAutoplay()"
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
                    class="absolute left-2 top-1/2 -translate-y-1/2 bg-black/55 hover:bg-black/75 text-white p-2 rounded-full transition-all duration-200 z-20 opacity-100 md:opacity-0 md:group-hover:opacity-100">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            </button>
            
            <!-- Botón Derecha -->
            <button @click.prevent.stop="next()" 
                    class="absolute right-2 top-1/2 -translate-y-1/2 bg-black/55 hover:bg-black/75 text-white p-2 rounded-full transition-all duration-200 z-20 opacity-100 md:opacity-0 md:group-hover:opacity-100">
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
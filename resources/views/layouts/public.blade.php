<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Carlos Codes | Full Stack Developer</title>
    <meta name="description" content="Desarrollo de aplicaciones y webs para particulares y empresas. +7 años desarrollando software. Cuéntame tu idea y te devolveré un producto real."> <!-- Snippet en búsqueda de Google -->
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

    <!-- Estilos Globales -->
    <style>
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        
        .skill-tag { display: inline-flex; align-items: center; padding: 0.25rem 0.75rem; background-color: #f9fafb; border: 1px solid #e5e7eb; border-radius: 9999px; font-size: 0.875rem; font-weight: 500; color: #374151; cursor: default; transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1); }
        .skill-tag:hover { transform: scale(1.05); border-color: #818cf8; background-color: #eef2ff; color: #4f46e5; }
        .dark .skill-tag { background-color: #1f2937; border-color: #374151; color: #d1d5db; }
        .dark .skill-tag:hover { background-color: #312e81; border-color: #6366f1; color: #a5b4fc; }

        .footer-btn { display: inline-flex; align-items: center; gap: 0.625rem; padding: 0.5rem 0.75rem; background-color: transparent; border: 1px solid transparent; border-radius: 0.5rem; font-size: 0.875rem; font-weight: 500; color: #9ca3af; transition: all 0.3s ease; cursor: pointer; }
        .group:hover .footer-btn { background-color: rgba(31, 41, 55, 0.5); }
        .group:hover .icon-linkedin { color: #0077b5; }
        .group:hover .icon-github { color: #3CCF91; }
        .group:hover .icon-email { color: #818cf8; }

        html { scrollbar-width: none; -ms-overflow-style: none; }
        html::-webkit-scrollbar { display: none; }

        #scroll-progress-container { position: fixed; right: 0; top: 0; width: 4px; height: 100%; background-color: rgba(229, 231, 235, 0.3); z-index: 100; }
        .dark #scroll-progress-container { background-color: rgba(55, 65, 81, 0.3); }
        #scroll-progress-bar { width: 100%; height: 0%; background: linear-gradient(to bottom, #818cf8, #4f46e5); box-shadow: 0 0 8px rgba(79, 70, 229, 0.5); transition: height 0.1s ease-out; }

        @keyframes float-natural { 
            0%   { transform: translate(0, 0) rotate(0deg); } 
            33%  { transform: translate(2px, -5px) rotate(0.8deg); } 
            66%  { transform: translate(-2px, -7px) rotate(-0.8deg); } 
            100% { transform: translate(0, 0) rotate(0deg); } 
        }
        .animate-floating { animation: float-natural 8s cubic-bezier(0.45, 0.05, 0.55, 0.95) infinite; }

        /* GitHub Icon Animation (sutil pero notable) */
        .hover-wiggle {
            transition: transform 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
        }
        .group:hover .hover-wiggle, .hover-wiggle:hover {
            transform: scale(1.15) rotate(-10deg);
        }

        .hover-pop {
            transition: transform 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
        }
        .group:hover .hover-pop, .hover-pop:hover {
            transform: scale(1.15);
        }

        /* Email Icon Animation (real envelope depth behavior) */
        .hover-email .email-state-closed,
        .hover-email .email-state-open {
            transition: opacity 0.35s ease;
        }
        .hover-email .email-state-open {
            opacity: 0;
        }
        .hover-email .email-open-letter {
            transform: translateY(0);
            transition: transform 0.45s cubic-bezier(0.34, 1.56, 0.64, 1) 0.1s;
        }
        .hover-email .email-open-flap-front,
        .hover-email .email-open-flap-back {
            transform-origin: center 112px;
            transition: transform 0.42s cubic-bezier(0.34, 1.56, 0.64, 1), opacity 0.2s ease;
        }
        /* Solapa visible delante cuando esta cerrado */
        .hover-email .email-open-flap-front {
            opacity: 1;
            transform: translateY(0) scaleY(1);
        }
        /* Solapa "trasera": misma geometria pero oculta al inicio */
        .hover-email .email-open-flap-back {
            opacity: 0;
            transform: translateY(-30px) scaleY(0.05);
        }
        .group:hover .hover-email .email-state-closed,
        .hover-email:hover .email-state-closed {
            opacity: 0;
        }
        .group:hover .hover-email .email-state-open,
        .hover-email:hover .email-state-open {
            opacity: 1;
        }
        .group:hover .hover-email .email-open-letter,
        .hover-email:hover .email-open-letter {
            transform: translateY(-70px);
        }
        /* La solapa delantera se abre y desaparece (pasa "hacia atras") */
        .group:hover .hover-email .email-open-flap-front,
        .hover-email:hover .email-open-flap-front {
            opacity: 0;
            transform: translateY(-30px) scaleY(0.05);
        }
        /* Aparece la solapa trasera, por detras de la carta */
        .group:hover .hover-email .email-open-flap-back,
        .hover-email:hover .email-open-flap-back {
            opacity: 1;
            transform: translateY(-30px) scaleY(0.05);
        }

        /* Footer name VFX: shimmer + cursor glow + letter stagger */
        .footer-name-wrapper {
            position: relative;
            overflow: visible;
        }
        .footer-name-wrapper::after {
            content: "";
            position: absolute;
            left: -40px; right: -40px; top: -20px; bottom: -20px;
            background: radial-gradient(
                420px circle at var(--mouse-x, 50%) var(--mouse-y, 50%),
                rgba(129, 140, 248, 0.32),
                transparent 50%
            );
            opacity: 0;
            transition: opacity 0.3s ease;
            pointer-events: none;
            z-index: -1;
        }
        .footer-name-wrapper:hover::after {
            opacity: 1;
        }
        /* Capa base: color sólido, siempre visible */
        .footer-name-vfx-base {
            position: relative;
            z-index: 0;
            font-weight: inherit;
            color: inherit;
        }
        /* Capa superior: solo el barrido de luz; oculta por defecto para evitar blanco a la derecha y salto al quitar hover */
        .footer-name-vfx-sweep {
            position: absolute;
            left: 0;
            top: 0;
            z-index: 1;
            font-weight: inherit;
            pointer-events: none;
            background: linear-gradient(
                90deg,
                transparent 0%,
                transparent 50%,
                rgba(255, 255, 255, 0.98) 58%,
                rgba(255, 255, 255, 0.95) 65%,
                transparent 72%,
                transparent 100%
            );
            background-size: 200% 100%;
            background-repeat: no-repeat;
            background-position: 0 0;
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
            color: transparent;
            opacity: 0;
            transition: opacity 0.18s ease-out;
        }
        .footer-name-wrapper:hover .footer-name-vfx-sweep {
            opacity: 1;
            background-position: 100% 0;
            transition: opacity 0.2s ease, background-position 0.55s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .footer-name-char {
            display: inline-block;
            transition: transform 0.35s cubic-bezier(0.4, 0, 0.2, 1);
            transition-delay: calc(var(--char-index) * 22ms);
        }
        .footer-name-wrapper:hover .footer-name-char {
            transform: translateY(-1.2px);
        }
        /* Hero: mismo efecto de letras, sin halo externo */
        .hero-name-vfx::after {
            display: none;
        }
        /* Ajustes del split por letras en hero */
        .hero-name-vfx .footer-name-vfx-base,
        .hero-name-vfx .footer-name-vfx-sweep {
            font-size: inherit;
            line-height: inherit;
        }
        .hero-name-vfx .footer-name-char {
            font-size: inherit;
            line-height: inherit;
            transform-origin: 50% 70%;
        }
        @keyframes hero-wave-expand {
            0%, 100% { transform: translateY(0); }
            40% { transform: translateY(-2px); }
            70% { transform: translateY(-0.5px); }
        }
        .hero-name-vfx:hover .footer-name-char {
            animation: hero-wave-expand 0.55s cubic-bezier(0.34, 1.56, 0.64, 1) both;
            animation-delay: calc(var(--char-index) * 26ms);
        }
        /* "Diseño & Desarrollo": mismo color, reflejo metálico que sigue al ratón */
        .footer-design-wrapper {
            position: relative;
            overflow: visible;
        }
        .footer-design-base {
            position: relative;
            z-index: 0;
            color: inherit;
            transition: none;
        }
        .footer-design-reflection {
            position: absolute;
            left: 0;
            top: 0;
            z-index: 1;
            pointer-events: none;
            background: radial-gradient(
                120px circle at var(--mouse-x, 50%) var(--mouse-y, 50%),
                rgba(255, 255, 255, 0.9) 0%,
                rgba(255, 255, 255, 0.5) 12%,
                rgba(255, 255, 255, 0.15) 25%,
                transparent 45%
            );
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
            color: transparent;
            opacity: 0;
            transition: opacity 0.25s ease;
        }
        .footer-design-wrapper:hover .footer-design-reflection {
            opacity: 1;
        }
    </style>

    <script>
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
</head>
<body class="antialiased bg-gray-50 text-gray-900 dark:bg-gray-900 dark:text-gray-100 font-sans flex flex-col min-h-screen transition-colors duration-300">
    
    <div id="scroll-progress-container"><div id="scroll-progress-bar"></div></div>

    <!-- Incluimos el Menú de navegación -->
    @include('partials.navbar')

    <!-- AQUÍ SE INYECTARÁ EL CONTENIDO DE LA VISTA -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Incluimos el pie de página -->
    @include('partials.footer')

    <!-- BOTÓN SCROLL TO TOP -->
    <div id="scrollToTopBtn" onclick="window.scrollTo({top: 0, behavior: 'smooth'})" class="fixed right-8 z-50 pointer-events-none" style="opacity: 0; transform: translateY(20px); bottom: 32px;">
        <div class="h-12 w-12 rounded-full bg-indigo-600 hover:bg-indigo-500 cursor-pointer flex items-center justify-center shadow-lg shadow-indigo-500/30 hover:shadow-indigo-500/50 transition-colors duration-300" role="button" tabindex="0">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" class="text-white"><path d="m18 15-6-6-6 6"></path></svg>
        </div>
    </div>

    <!-- Scripts Generales de la Interfaz -->
    <script>
        // 1. Scroll to Top
        const scrollBtn = document.getElementById('scrollToTopBtn');
        const footer = document.getElementById('main-footer');
        let isVisible = false;

        window.addEventListener('scroll', () => {
            if (window.scrollY > 300) {
                scrollBtn.classList.remove('opacity-0', 'pointer-events-none', 'translate-y-10');
                scrollBtn.classList.add('opacity-100', 'translate-y-0');
            } else {
                scrollBtn.classList.add('opacity-0', 'pointer-events-none', 'translate-y-10');
                scrollBtn.classList.remove('opacity-100', 'translate-y-0');
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            if (!scrollBtn || !footer) return;
            const baseBottom = 32;
            scrollBtn.style.transition = "opacity 0.4s ease, transform 0.4s ease";
            function updateButton() {
                const footerRect = footer.getBoundingClientRect();
                const windowHeight = window.innerHeight;
                const scrollY = window.scrollY;

                if (scrollY > 300 && !isVisible) {
                    isVisible = true; scrollBtn.style.opacity = "1"; scrollBtn.style.pointerEvents = "auto"; scrollBtn.style.transform = "translateY(0)";
                } else if (scrollY <= 300 && isVisible) {
                    isVisible = false; scrollBtn.style.opacity = "0"; scrollBtn.style.pointerEvents = "none"; scrollBtn.style.transform = "translateY(20px)";
                }

                if (footerRect.top < windowHeight) {
                    const overlap = windowHeight - footerRect.top;
                    scrollBtn.style.bottom = (baseBottom + overlap) + "px";
                } else {
                    scrollBtn.style.bottom = baseBottom + "px";
                }
                requestAnimationFrame(updateButton);
            }
            requestAnimationFrame(updateButton);
        }); 

        // 2. Seguimiento del ratón (Tarjetas + textos con efectos)
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('.js-spotlight-card, .js-project-card').forEach(card => {
                card.addEventListener('mousemove', (e) => {
                    const rect = card.getBoundingClientRect();
                    card.style.setProperty('--mouse-x', `${e.clientX - rect.left}px`);
                    card.style.setProperty('--mouse-y', `${e.clientY - rect.top}px`);
                });
            });
            const nameSpotlights = document.querySelectorAll('.js-footer-name-spotlight');
            const designSpotlights = document.querySelectorAll('.js-footer-design-spotlight');

            document.addEventListener('mousemove', (e) => {
                nameSpotlights.forEach((nameSpotlight) => {
                    const rect = nameSpotlight.getBoundingClientRect();
                    const x = e.clientX - rect.left;
                    const y = e.clientY - rect.top;
                    if (x >= 0 && x <= rect.width && y >= 0 && y <= rect.height) {
                        nameSpotlight.style.setProperty('--mouse-x', `${x}px`);
                        nameSpotlight.style.setProperty('--mouse-y', `${y}px`);
                    }
                });

                designSpotlights.forEach((designSpotlight) => {
                    const rect = designSpotlight.getBoundingClientRect();
                    const x = e.clientX - rect.left;
                    const y = e.clientY - rect.top;
                    if (x >= 0 && x <= rect.width && y >= 0 && y <= rect.height) {
                        designSpotlight.style.setProperty('--mouse-x', `${x}px`);
                        designSpotlight.style.setProperty('--mouse-y', `${y}px`);
                    }
                });
            });

            nameSpotlights.forEach((nameSpotlight) => {
                const sweep = nameSpotlight.querySelector('.footer-name-vfx-sweep');
                if (!sweep) return;
                nameSpotlight.addEventListener('mouseleave', () => {
                    function resetPosition(e) {
                        if (e.propertyName === 'opacity') {
                            sweep.style.backgroundPosition = '0 0';
                            sweep.removeEventListener('transitionend', resetPosition);
                        }
                    }
                    sweep.addEventListener('transitionend', resetPosition);
                });
            });
        });

        // 3. Barra de Progreso Vertical
        window.addEventListener('scroll', () => {
            const progressBar = document.getElementById('scroll-progress-bar');
            const winScroll = document.body.scrollTop || document.documentElement.scrollTop;
            const height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
            progressBar.style.height = (winScroll / height) * 100 + "%";
        });
    </script>

    <!-- Espacio para inyectar scripts específicos de cada vista -->
    @stack('scripts')
</body>
</html>
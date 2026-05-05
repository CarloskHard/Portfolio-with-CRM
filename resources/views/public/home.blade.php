@extends('layouts.public')

@section('content')

    {{-- ┌──────────────────────────────────────────────────────────────┐
         │  WebGL fluid canvas — fixed full-page background             │
         │  Always renders exactly the visible viewport (100vw×100vh),  │
         │  never more. Sections scroll over it; the pattern appears    │
         │  seamlessly continuous across the entire page.               │
         └──────────────────────────────────────────────────────────────┘ --}}
    <canvas id="hero-fluid-canvas"
            style="position:fixed;inset:0;width:100vw;height:100vh;height:100lvh;display:block;z-index:0;pointer-events:none;transform:translateZ(0);-webkit-transform:translateZ(0);"
            aria-hidden="true"></canvas>

    <!--
    |------------------------------------------------------------------|
    |  ##########               HERO SECTION               ##########  |
    |  Theme: HeroSoft — fluid WebGL background, Geist editorial type  |
    |------------------------------------------------------------------|
    -->
    <style>
        /* ── Hero Soft design system ── */
        /* Full-page shader background: body must be transparent */
        body { background: transparent !important; }
        /* Same base as the shader light/dark clear colour — fills root gaps on mobile compositing */
        html { background-color: #ffffff; }
        html.dark { background-color: #111827; }

        .hero-soft-section {
            /* ~82svh: alto hero con un poco de la siguiente sección visible al cargar */
            min-height: 82svh;
            background: transparent;
            position: relative;
            overflow: hidden;   /* clip ambos ejes de forma consistente; overflow-x:clip + overflow-y:visible viola la spec CSS (visible se convierte en auto, creando scroll container que recorta la imagen) */
        }
        .dark .hero-soft-section {
            background: transparent;
        }
        /* Primera palabra del titular — tono más oscuro que cA del shader para no fundirse */
        .hero-title-accent {
            color: #0d9488; /* teal-600 — contrasta sobre el shader claro */
            text-shadow:
                0 0 18px rgba(255, 255, 255, 0.55),
                0 0 36px rgba(255, 255, 255, 0.22);
        }
        .dark .hero-title-accent {
            color: #5eead4; /* teal-300 — luminoso sobre fondo oscuro */
            text-shadow:
                0 0 16px rgba(15, 118, 110, 0.45),
                0 0 32px rgba(0, 0, 0, 0.3);
        }
        /* Una línea del H1 editorial: hueco entre cajas resaltadas arriba/abajo */
        .hero-headline-line {
            display: block;
        }
        .hero-headline-line:not(:last-child) {
            margin-bottom: clamp(0.12em, 2.2vmin, 0.34em);
        }
        /* Highlight blocks: mismo material que tarjetas #services (mate + grano SVG) */
        .hero-hl {
            display: inline-block;
            background-color: rgba(236, 240, 248, 0.93);
            background-image: var(--section-matte-grain);
            background-size: 144px 144px;
            background-blend-mode: overlay;
            color: #0f172a;
            border: 2px solid rgba(100, 116, 139, 0.24);
            box-shadow:
                inset 0 1px 0 rgba(255, 255, 255, 0.82),
                inset 0 -1px 0 rgba(71, 85, 105, 0.06),
                0 1px 2px rgba(51, 65, 85, 0.05),
                0 6px 18px rgba(51, 65, 85, 0.07);
            padding: 0 0.1em 0.02em;
            border-radius: 10px;
            margin: 0 0.03em;
            line-height: 0.92;
            vertical-align: baseline;
        }
        .dark .hero-hl {
            background-color: rgba(44, 47, 54, 0.9);
            background-image: var(--section-matte-grain);
            background-blend-mode: soft-light;
            color: #f1f5f9;
            border: 2px solid rgba(148, 163, 184, 0.2);
            box-shadow:
                inset 0 1px 0 rgba(255, 255, 255, 0.07),
                inset 0 -1px 0 rgba(0, 0, 0, 0.38),
                0 2px 4px rgba(0, 0, 0, 0.16),
                0 8px 22px rgba(0, 0, 0, 0.24);
        }
        /* 3-column sub-grid */
        .hero-sub-grid {
            display: grid;
            grid-template-columns: auto 1fr auto;
            align-items: end;
            gap: clamp(20px, 4vw, 72px);
            max-width: 1200px;
            margin-top: clamp(32px, 5vh, 60px);
        }
        /* Social rail */
        .hero-socials-rail {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 16px;
        }
        .hero-social-link {
            color: #0a0a0a;
            display: block;
            transition: opacity 0.2s;
        }
        .dark .hero-social-link {
            color: #e5e7eb;
        }
        .hero-social-link:hover { opacity: 0.4; }
        /* CTA buttons */
        .hero-cta-primary {
            display: inline-flex;
            align-items: center;
            gap: 14px;
            padding: 13px 24px 13px 13px;
            border: 1.5px solid #0a0a0a;
            border-radius: 999px;
            background: rgba(255,255,255,0.65);
            backdrop-filter: blur(6px);
            font-family: 'Geist', system-ui, sans-serif;
            font-size: 15px;
            font-weight: 500;
            color: #0a0a0a;
            text-decoration: none;
            transition:
                background 0.2s ease,
                transform 0.22s cubic-bezier(0.34, 1.56, 0.64, 1);
        }
        .hero-cta-primary:hover {
            background: rgba(10,10,10,0.07);
            color: #0a0a0a;
            transform: scale(1.045);
        }
        .dark .hero-cta-primary {
            border-color: rgba(229, 231, 235, 0.6);
            background: rgba(24, 26, 31, 0.6);
            color: #f9fafb;
        }
        .dark .hero-cta-primary:hover {
            background: rgba(229, 231, 235, 0.12);
            color: #ffffff;
            transform: scale(1.045);
        }
        .hero-cta-secondary {
            display: inline-flex;
            align-items: center;
            padding: 13px 24px;
            border: 1.5px solid rgba(10,10,10,0.2);
            border-radius: 999px;
            background: rgba(255,255,255,0.45);
            backdrop-filter: blur(6px);
            font-family: 'Geist', system-ui, sans-serif;
            font-size: 15px;
            font-weight: 500;
            color: #3a3a38;
            text-decoration: none;
            transition:
                background 0.2s ease,
                transform 0.22s cubic-bezier(0.34, 1.56, 0.64, 1);
        }
        .hero-cta-secondary:hover {
            background: rgba(10,10,10,0.05);
            color: #0a0a0a;
            transform: scale(1.045);
        }
        .dark .hero-cta-secondary {
            border-color: rgba(229, 231, 235, 0.25);
            background: rgba(24, 26, 31, 0.5);
            color: #d1d5db;
        }
        .dark .hero-cta-secondary:hover {
            background: rgba(229, 231, 235, 0.08);
            color: #ffffff;
            transform: scale(1.045);
        }
        .dark .hero-soft-section [data-hero-primary] { color: #f9fafb !important; }
        .dark .hero-soft-section [data-hero-muted] { color: #9ca3af !important; }
        /*
         * Más intensidad sólo en el tinte del glifo (+ halo muy suave), sin fondo propio:
         * el mint/índigo del shader queda más atrás contra un gris casi tinta / blanco papel.
         */
        .hero-soft-section [data-hero-body] {
            font-weight: 400;
            color: #1a1b19 !important;
            text-shadow:
                0 0 14px rgba(255, 255, 255, 0.52),
                0 0 32px rgba(255, 255, 255, 0.22);
        }
        .dark .hero-soft-section [data-hero-body] {
            color: #eef0f4 !important;
            text-shadow:
                0 0 14px rgba(12, 14, 18, 0.45),
                0 0 28px rgba(0, 0, 0, 0.2);
        }
        .dark .hero-soft-section [data-hero-divider] { background: rgba(229, 231, 235, 0.25) !important; }
        .dark .hero-soft-section [data-hero-cta-icon] {
            background: #f9fafb !important;
            color: #181a1f !important;
        }
        /* Availability pulse dot */
        .hero-dot-pulse {
            display: inline-block;
            width: 7px; height: 7px;
            border-radius: 999px;
            background: #22c55e;
            box-shadow: 0 0 0 0 rgba(34,197,94,0.45);
            animation: hero-dot-pulse 2.4s ease-in-out infinite;
            vertical-align: middle;
            flex-shrink: 0;
        }
        @keyframes hero-dot-pulse {
            0%,100% { box-shadow: 0 0 0 0 rgba(34,197,94,0.45); }
            50%      { box-shadow: 0 0 0 5px rgba(34,197,94,0); }
        }
        /* Two-column hero layout */
        .hero-layout {
            display: grid;
            grid-template-columns: 1fr auto;
            align-items: end;
            gap: clamp(32px, 4vw, 64px);
        }
        .hero-image-col {
            /* Desde un poco bajo el header fijo hasta el borde inferior de la sección.
               El containing block es el div content-layer (position:relative). */
            position: absolute;
            top: clamp(72px, 5.25rem, 92px);
            bottom: 0;
            right: clamp(20px, 5.5vw, 88px);
            width: min(52vw, 820px);
            z-index: 2;
            display: block;
            pointer-events: none;
        }

        /* Mismo ancho/caja que la foto: el tinte no “ensucia” el hueco del column */
        .hero-profile-wrap {
            height: 100%;
            width: fit-content;
            max-width: 100%;
            margin-left: auto;
            position: relative;
            pointer-events: none;
            /* isolation: isolate crea un grupo de composición aislado: los blend-modes
               de ::before/::after operan contra los píxeles internos del grupo (la imagen),
               no contra el fondo de la página. Donde el PNG tiene alpha=0, la salida del
               grupo también es transparente → sin tinte sobre el fondo. */
            isolation: isolate;
            /* Elipse original; transición más “fuerte” al arrancar desde la esquina (paradas intermedias) */
            --hero-img-fade: radial-gradient(
                ellipse 150% 100% at 0% 100%,
                transparent 0%,
                transparent 3%,
                rgba(0, 0, 0, 0.48) 13%,
                rgba(0, 0, 0, 0.9) 24%,
                black 52%
            );
        }

        .dark .hero-profile-wrap {
            --hero-img-fade: radial-gradient(
                ellipse 150% 100% at 0% 100%,
                transparent 0%,
                transparent 3%,
                rgba(0, 0, 0, 0.52) 12%,
                rgba(0, 0, 0, 0.94) 22%,
                black 50%
            );
        }

        /* Pseudo-elementos de tinte eliminados: el mask-image geométrico no puede
           seguir el alpha channel del WebP sin causar artefactos (halo, sangrado).
           La integración visual viene del mask-image fade en la propia imagen
           + filter: saturate/brightness + el shader WebGL de fondo. */

        .hero-profile-img {
            display: block;
            height: 100%;
            width: auto;
            max-width: 100%;
            position: relative;
            z-index: 0;
            object-fit: contain;
            object-position: bottom center;

            /* ── Integración ambiental sin distorsión de color ──
               mix-blend-mode sobre overlays externos tiñe el fondo en zonas
               transparentes. hue-rotate con ángulos grandes (>30°) distorsiona
               los tonos piel. La integración correcta viene del mask-image fade
               + el shader de fondo: solo necesitamos reducir la saturación y el
               contraste para que la imagen "retroceda" hacia el entorno. */
            filter: saturate(0.88) brightness(0.97);

            mask-image: var(--hero-img-fade);
            -webkit-mask-image: var(--hero-img-fade);

            transition: filter 0.3s ease;
        }
        .dark .hero-profile-img {
            /* En dark mode oscurecemos para integrarnos con el fondo #181a1f */
            filter: saturate(0.82) brightness(0.80) contrast(1.05);
        }
        /* Responsive collapse */
        @media (max-width: 900px) {
            .hero-layout {
                grid-template-columns: 1fr;
            }
            .hero-image-col { display: none; }
        }
        /*
         * Ocultar imagen en orientación portrait, independientemente del ancho del viewport.
         * Esto cubre el caso de "modo ordenador/desktop" en móvil: el navegador simula
         * un viewport ancho (>900px) pero la pantalla física sigue siendo portrait.
         * Limit a max-width:1200px para no afectar monitores de escritorio en portrait.
         * También ocultar cuando el viewport es demasiado bajo (landscape en móvil pequeño).
         */
        @media (orientation: portrait) and (max-width: 1200px) {
            .hero-layout { grid-template-columns: 1fr; }
            .hero-image-col { display: none; }
        }
        @media (max-height: 520px) {
            .hero-image-col { display: none; }
        }
        @media (max-width: 767px) {
            .hero-sub-grid {
                grid-template-columns: 1fr !important;
                gap: 28px !important;
            }
            .hero-socials-rail {
                flex-direction: row !important;
                gap: 20px !important;
            }
            .hero-socials-handle {
                writing-mode: horizontal-tb !important;
                transform: none !important;
            }
            .hero-status-block { display: none !important; }
        }
        @media (max-width: 480px) {
            .hero-eyebrow-row { display: none; }
        }

        /*
         * Paneles de sección: material mate semitransparente + grano SVG (sin blur / sin “cristal”).
         */
        .section-glass-panel {
            /* Grano: --section-matte-grain en resources/css/app.css (:root) */
            background-color: rgba(244, 245, 248, 0.88);
            background-image: var(--section-matte-grain);
            background-size: 160px 160px;
            background-blend-mode: overlay;
            border: 2px solid rgba(15, 23, 42, 0.11);
            box-shadow:
                inset 0 1px 0 rgba(255, 255, 255, 0.65),
                inset 0 -1px 0 rgba(15, 23, 42, 0.05),
                0 2px 4px rgba(15, 23, 42, 0.04),
                0 10px 32px rgba(15, 23, 42, 0.08);
        }
        .dark .section-glass-panel {
            background-color: rgba(26, 28, 33, 0.86);
            background-image: var(--section-matte-grain);
            background-blend-mode: soft-light;
            border: 2px solid rgba(226, 232, 240, 0.14);
            box-shadow:
                inset 0 1px 0 rgba(255, 255, 255, 0.09),
                inset 0 -1px 0 rgba(0, 0, 0, 0.45),
                0 4px 6px rgba(0, 0, 0, 0.2),
                0 14px 40px rgba(0, 0, 0, 0.28);
        }
        /* Mayor especificidad que spotlight.css (.js-spotlight-card) */
        .js-spotlight-card.section-inner-card,
        .skill-card.section-inner-card {
            background-color: rgba(250, 250, 252, 0.9) !important;
            background-image: var(--section-matte-grain) !important;
            background-size: 144px 144px !important;
            background-blend-mode: overlay !important;
            border: 2px solid rgba(15, 23, 42, 0.1) !important;
            box-shadow:
                inset 0 1px 0 rgba(255, 255, 255, 0.75),
                inset 0 -1px 0 rgba(15, 23, 42, 0.04),
                0 1px 2px rgba(15, 23, 42, 0.05),
                0 6px 18px rgba(15, 23, 42, 0.06);
        }
        .dark .js-spotlight-card.section-inner-card,
        .dark .skill-card.section-inner-card {
            background-color: rgba(34, 36, 41, 0.9) !important;
            background-image: var(--section-matte-grain) !important;
            background-blend-mode: soft-light !important;
            border: 2px solid rgba(226, 232, 240, 0.12) !important;
            box-shadow:
                inset 0 1px 0 rgba(255, 255, 255, 0.08),
                inset 0 -1px 0 rgba(0, 0, 0, 0.4),
                0 2px 4px rgba(0, 0, 0, 0.18),
                0 8px 22px rgba(0, 0, 0, 0.22);
        }
        .js-spotlight-card.section-inner-card:hover,
        .skill-card.section-inner-card:hover {
            border-color: rgba(15, 23, 42, 0.18) !important;
            box-shadow:
                inset 0 1px 0 rgba(255, 255, 255, 0.85),
                inset 0 -1px 0 rgba(15, 23, 42, 0.05),
                0 2px 3px rgba(15, 23, 42, 0.06),
                0 10px 28px rgba(15, 23, 42, 0.1);
        }
        .dark .js-spotlight-card.section-inner-card:hover,
        .dark .skill-card.section-inner-card:hover {
            border-color: rgba(226, 232, 240, 0.2) !important;
            box-shadow:
                inset 0 1px 0 rgba(255, 255, 255, 0.1),
                inset 0 -1px 0 rgba(0, 0, 0, 0.45),
                0 4px 8px rgba(0, 0, 0, 0.22),
                0 12px 36px rgba(0, 0, 0, 0.34);
        }
        /* Servicios: panel y tarjetas algo más fríos/grisáceos (solo esta sección) */
        #services.section-glass-panel {
            background-color: rgba(228, 231, 236, 0.9);
        }
        .dark #services.section-glass-panel {
            background-color: rgba(40, 42, 48, 0.88);
        }
        #services .js-spotlight-card.section-inner-card {
            background-color: rgba(236, 240, 248, 0.93) !important;
            border: 2px solid rgba(100, 116, 139, 0.24) !important;
            box-shadow:
                inset 0 1px 0 rgba(255, 255, 255, 0.82),
                inset 0 -1px 0 rgba(71, 85, 105, 0.06),
                0 1px 2px rgba(51, 65, 85, 0.05),
                0 6px 18px rgba(51, 65, 85, 0.07);
        }
        .dark #services .js-spotlight-card.section-inner-card {
            background-color: rgba(44, 47, 54, 0.9) !important;
            border: 2px solid rgba(148, 163, 184, 0.2) !important;
            box-shadow:
                inset 0 1px 0 rgba(255, 255, 255, 0.07),
                inset 0 -1px 0 rgba(0, 0, 0, 0.38),
                0 2px 4px rgba(0, 0, 0, 0.16),
                0 8px 22px rgba(0, 0, 0, 0.24);
        }
        #services .js-spotlight-card.section-inner-card:hover {
            border-color: rgba(71, 85, 105, 0.38) !important;
            box-shadow:
                inset 0 1px 0 rgba(255, 255, 255, 0.92),
                inset 0 -1px 0 rgba(71, 85, 105, 0.08),
                0 2px 4px rgba(51, 65, 85, 0.07),
                0 10px 30px rgba(51, 65, 85, 0.12);
        }
        .dark #services .js-spotlight-card.section-inner-card:hover {
            border-color: rgba(148, 163, 184, 0.32) !important;
            box-shadow:
                inset 0 1px 0 rgba(255, 255, 255, 0.09),
                inset 0 -1px 0 rgba(0, 0, 0, 0.48),
                0 4px 8px rgba(0, 0, 0, 0.2),
                0 12px 38px rgba(0, 0, 0, 0.4);
        }
    </style>

    <section id="home" class="hero-soft-section">

        {{-- Content layer --}}
        <div style="position:relative;z-index:2;display:flex;flex-direction:column;min-height:82svh;">

            {{-- Spacer matching the fixed navbar height (~68px) --}}
            <div style="flex-shrink:0;height:68px;"></div>

            {{-- Vertically centred main body --}}
            <div style="flex:1;display:flex;flex-direction:column;justify-content:center;
                        padding:0 clamp(20px,5.5vw,88px) clamp(28px,4vh,56px);">

                <div class="hero-layout">

                {{-- LEFT: text content --}}
                <div>

                {{-- Eyebrow: status pill --}}
                <div class="hero-eyebrow-row"
                     style="display:flex;align-items:center;gap:10px;margin-bottom:clamp(22px,3.5vh,46px);">
                    <span class="hero-dot-pulse"></span>
                    <span style="font-family:'JetBrains Mono',monospace;font-size:12px;
                                 letter-spacing:0.1em;text-transform:uppercase;
                                 color:#0a0a0a;font-weight:600;" data-hero-primary>Disponible</span>
                    <span style="font-family:'JetBrains Mono',monospace;font-size:12px;
                                 letter-spacing:0.1em;color:#7a7a76;" data-hero-muted>· Sevilla · UTC+1</span>
                </div>

                {{-- Big editorial headline --}}
                <h1 style="font-family:'Geist',system-ui,sans-serif;
                            font-weight:600;
                            font-size:clamp(44px,8.5vw,124px);
                            line-height:1.03;
                            letter-spacing:-0.035em;
                            color:#0a0a0a;
                            margin:0;" data-hero-primary>
                    <span class="hero-headline-line"><span class="hero-title-accent">Dando</span>&nbsp;<span class="hero-hl">vida</span></span>
                    <span class="hero-headline-line">a &nbsp;<span class="hero-hl">tus ideas</span></span>
                </h1>

                {{-- Sub-grid: socials rail | copy+CTA | status --}}
                <div class="hero-sub-grid">

                    {{-- Social icons (vertical rail) --}}
                    <div class="hero-socials-rail">
                        <a href="{{ env('APP_GITHUB_URL', 'https://github.com/CarlosBTav') }}"
                           target="_blank" rel="noopener noreferrer"
                           class="hero-social-link" title="GitHub">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                <path d="M12 .5C5.65.5.5 5.65.5 12c0 5.08 3.29 9.39 7.86 10.91.58.1.79-.25.79-.56v-2c-3.2.69-3.87-1.36-3.87-1.36-.52-1.32-1.27-1.67-1.27-1.67-1.04-.71.08-.7.08-.7 1.15.08 1.76 1.18 1.76 1.18 1.02 1.75 2.69 1.25 3.34.95.1-.74.4-1.25.73-1.54-2.55-.29-5.24-1.28-5.24-5.69 0-1.26.45-2.29 1.18-3.1-.12-.29-.51-1.46.11-3.04 0 0 .96-.31 3.15 1.18.91-.25 1.89-.38 2.86-.38s1.95.13 2.86.38c2.18-1.49 3.14-1.18 3.14-1.18.62 1.58.23 2.75.11 3.04.74.81 1.18 1.84 1.18 3.1 0 4.42-2.69 5.4-5.26 5.68.41.36.78 1.06.78 2.15v3.18c0 .31.21.67.8.56C20.21 21.39 23.5 17.08 23.5 12 23.5 5.65 18.35.5 12 .5z"/>
                            </svg>
                        </a>
                        <a href="{{ env('APP_LINKEDIN_URL', 'https://www.linkedin.com/in/carlos-b-6a8a9a2b5/') }}"
                           target="_blank" rel="noopener noreferrer"
                           class="hero-social-link" title="LinkedIn">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                <path d="M4.98 3.5C4.98 4.88 3.87 6 2.5 6S0 4.88 0 3.5 1.12 1 2.5 1s2.48 1.12 2.48 2.5zM.22 8.5h4.56V23H.22V8.5zM8.34 8.5h4.37v1.98h.06c.61-1.15 2.1-2.36 4.32-2.36 4.62 0 5.47 3.04 5.47 7v7.88h-4.56v-6.99c0-1.67-.03-3.82-2.33-3.82-2.33 0-2.69 1.82-2.69 3.7V23H8.34V8.5z"/>
                            </svg>
                        </a>
                        <div style="width:1px;height:28px;background:rgba(10,10,10,0.15);" data-hero-divider></div>
                        <span class="hero-socials-handle"
                              style="font-family:'JetBrains Mono',monospace;font-size:10px;
                                     letter-spacing:0.14em;color:#7a7a76;
                                     writing-mode:vertical-rl;transform:rotate(180deg);
                                     user-select:none;" data-hero-muted>@carlos.codex</span>
                    </div>

                    {{-- Description + call-to-action buttons --}}
                    <div>
                        <p style="font-size:clamp(15px,1.2vw,17px);line-height:1.65;
                                  max-width:460px;margin:0;
                                  font-family:'Geist',system-ui,sans-serif;" data-hero-body>
                            Ingeniero full‑stack:<br>
                            Construyo aplicaciones web y móvil, sistemas y los pequeños detalles
                            que hacen que un producto se sienta cuidado.
                        </p>
                        <div style="margin-top:28px;display:flex;gap:12px;flex-wrap:wrap;align-items:center;">
                            <a href="#projects" class="hero-cta-primary">
                                <span style="width:34px;height:34px;border-radius:999px;
                                             background:#0a0a0a;color:#fff;
                                             display:inline-flex;align-items:center;
                                             justify-content:center;font-size:16px;
                                             flex-shrink:0;" data-hero-cta-icon>↗</span>
                                Ver proyectos
                            </a>
                            <a href="#contact" class="hero-cta-secondary">Contactar</a>
                        </div>
                    </div>

                    {{-- Right-aligned status metadata --}}
                    <div class="hero-status-block"
                         style="text-align:right;font-family:'JetBrains Mono',monospace;
                                font-size:10.5px;letter-spacing:0.14em;text-transform:uppercase;
                                color:#7a7a76;line-height:2;" data-hero-muted>
                        <div style="color:#0a0a0a;font-weight:600;display:flex;align-items:center;
                                    justify-content:flex-end;gap:7px;margin-bottom:1px;" data-hero-primary>
                            <span class="hero-dot-pulse"></span>Disponible · Q2 2026
                        </div>
                        <div>Sevilla · UTC+1</div>
                    </div>

                </div>{{-- /hero-sub-grid --}}

                </div>{{-- /LEFT text content --}}

                {{-- RIGHT: profile image --}}
                <div class="hero-image-col">
                    <div class="hero-profile-wrap">
                        <img src="{{ asset('img/me-noBg-dark.webp') }}"
                             alt="Carlos — Fullstack Developer"
                             class="hero-profile-img"
                             width="720" height="900"
                             loading="eager"
                             decoding="async">
                    </div>
                </div>{{-- /hero-image-col --}}

                </div>{{-- /hero-layout --}}

            </div>{{-- /main body --}}

        </div>{{-- /content layer --}}

    </section>

    <!--
    |------------------------------------------------------------------|
    |  ##########             SERVICIOS SECTION            ##########  |                
    |------------------------------------------------------------------|
    -->
    <section id="services" class="section-glass-panel relative z-10 py-24 transition-colors duration-300 overflow-hidden mx-3 md:mx-6 lg:mx-10 rounded-3xl mb-8">
        <!-- Decoración de fondo suave -->
        <div class="absolute top-0 left-0 -ml-20 -mt-20 w-72 h-72 bg-blue-400/10 dark:bg-blue-600/10 rounded-full blur-3xl pointer-events-none"></div>

        <div class="max-w-screen-xl px-4 mx-auto relative z-10">
            
            <!-- Cabecera de la sección -->
            <div class="text-center max-w-3xl mx-auto mb-16">
                <div class="flex items-center justify-center gap-2 mb-4">
                    <span class="relative flex h-3 w-3">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-3 w-3 bg-blue-500"></span>
                    </span>
                    <span class="text-blue-600 dark:text-blue-400 font-bold tracking-widest uppercase text-xs">
                        ¿Qué puedo hacer por ti?
                    </span>
                </div>
                
                <h2 class="text-3xl md:text-4xl lg:text-5xl font-extrabold text-gray-900 dark:text-white mb-6 leading-[1.15]">
                    Construye conmigo tu
                    <p> <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-500 to-indigo-600 dark:from-blue-400 dark:to-indigo-400">web o app móvil</span></p>
                </h2>
                <p class="text-base md:text-lg text-gray-600 dark:text-gray-300 leading-relaxed">
                    Soluciones tecnológicas a medida para impulsar tu carrera o tu negocio. Desde una presencia online profesional hasta herramientas avanzadas de gestión.
                </p>
            </div>

            <!-- Grid de Servicios -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-16">
                <!-- Servicio 1: Portfolio -->
                <div class="js-spotlight-card section-inner-card group p-8 rounded-2xl hover:shadow-xl hover:-translate-y-1 transition-all duration-300 relative overflow-hidden">
                    <div class="w-14 h-14 bg-white dark:bg-gray-800 rounded-xl shadow-sm flex items-center justify-center mb-6 text-indigo-500 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">Páginas Web y Portfolios</h3>
                    <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                        Destaca en internet con una web rápida, moderna y optimizada. Ideal para marca personal, creativos e individuos que quieren mostrar su trabajo al mundo.
                    </p>
                    {{-- Efecto de resplandor sutil al fondo esquina inferior derecha --}}
                    <div class="absolute -bottom-24 -right-24 w-48 h-48 bg-indigo-500/10 rounded-full blur-3xl group-hover:bg-indigo-500/20 transition-colors duration-500"></div>
                </div>

                <!-- Servicio 2: ERP & CRM -->
                <div class="js-spotlight-card section-inner-card group p-8 rounded-2xl hover:shadow-xl hover:-translate-y-1 transition-all duration-300 relative overflow-hidden">
                    <div class="w-14 h-14 bg-white dark:bg-gray-800 rounded-xl shadow-sm flex items-center justify-center mb-6 text-indigo-500 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">Sistemas de Gestión</h3>
                    <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                        Desarrollo de ERPs y CRMs a medida. Optimiza el tiempo de tu empresa organizando a tus clientes, facturación y procesos internos en un solo lugar seguro.
                    </p>
                    {{-- Efecto de resplandor sutil al fondo esquina inferior derecha --}}
                    <div class="absolute -bottom-24 -right-24 w-48 h-48 bg-indigo-500/10 rounded-full blur-3xl group-hover:bg-indigo-500/20 transition-colors duration-500"></div>
                </div>

                <!-- Servicio 3: Apps Móviles -->
                <div class="js-spotlight-card section-inner-card group p-8 rounded-2xl hover:shadow-xl hover:-translate-y-1 transition-all duration-300 relative overflow-hidden">
                    <div class="w-14 h-14 bg-white dark:bg-gray-800 rounded-xl shadow-sm flex items-center justify-center mb-6 text-indigo-500 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">Aplicaciones Móviles</h3>
                    <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                        Llevo tu idea a los bolsillos de tus usuarios. Desarrollo aplicaciones intuitivas, rápidas y listas para ser publicadas en las tiendas oficiales.
                    </p>
                    {{-- Efecto de resplandor sutil al fondo esquina inferior derecha --}}
                    <div class="absolute -bottom-24 -right-24 w-48 h-48 bg-indigo-500/10 rounded-full blur-3xl group-hover:bg-indigo-500/20 transition-colors duration-500"></div>
                </div>
            </div>

            <!-- Banner de Oferta y CTA -->
            <div class="relative bg-gradient-to-br from-indigo-50 via-white to-blue-50 dark:from-gray-800 dark:via-gray-800 dark:to-indigo-900/30 rounded-3xl p-8 md:p-12 border border-indigo-100 dark:border-gray-700 overflow-hidden shadow-lg">
                <!-- Decoración fondo banner -->
                <div class="absolute right-0 top-0 w-64 h-64 bg-gradient-to-br from-indigo-400 to-blue-500 opacity-10 dark:opacity-20 rounded-full blur-3xl transform translate-x-1/2 -translate-y-1/2"></div>
                
                <div class="relative z-10 flex flex-col lg:flex-row items-center justify-between gap-8 text-center lg:text-left">
                    <div class="max-w-2xl">
                        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-indigo-100 dark:bg-indigo-900/50 text-indigo-700 dark:text-indigo-300 text-sm font-semibold mb-4">
                            <span>🎁 Oferta especial por tiempo limitado</span>
                        </div>
                        <h3 class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-white mb-4">
                            Prototipo gratuito, sin compromiso.
                        </h3>
                        <p class="text-gray-600 dark:text-gray-300 text-lg">
                            Solo tienes que contarme tu idea. Diseñaré un prototipo visual para que veas cómo luciría tu proyecto <strong>totalmente gratis y sin compromiso</strong>. Si el resultado te apasiona entonces podemos proceder a hacerlo realidad por un precio super competitivo.
                        </p>
                    </div>
                    
<div class="flex-shrink-0 flex flex-col items-center lg:items-end gap-3">
    <a href="#contact" class="group relative inline-flex items-center justify-center px-8 py-4 w-full sm:w-auto text-base font-medium text-gray-900 dark:text-white bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-xl overflow-hidden transition-all duration-300 active:scale-95 shadow-sm">
        <!-- Fondo animado que entra por la izquierda -->
        <span class="absolute inset-0 w-full h-full bg-gray-100 dark:bg-gray-700 -translate-x-full group-hover:translate-x-0 transition-transform duration-300 ease-out"></span>
        
        <!-- El texto debe tener z-10 para quedar sobre el fondo que entra -->
        <span class="relative z-10">¡Me interesa!</span>
    </a>
    <span class="text-sm text-gray-500 dark:text-gray-400">Abierto a nuevas contrataciones</span>
</div>
                </div>
            </div>

        </div>
    </section>


    <!--
    |------------------------------------------------------------------|
    |  ##########             SOBRE MI SECTION             ##########  |
    |------------------------------------------------------------------|
    -->
    {{-- overflow-x-clip: el halo top-right usa -mr-20 y sobresale; sin clip el documento amplía scrollWidth en móvil --}}
    <section id="about" class="relative py-24 bg-transparent transition-colors duration-300 overflow-x-clip">
        <div class="absolute top-0 right-0 -mr-20 -mt-20 w-72 h-72 bg-indigo-400/10 dark:bg-indigo-600/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-24 -left-24 w-72 h-72 bg-indigo-500/10 dark:bg-indigo-500/18 rounded-full blur-3xl pointer-events-none hidden md:block"></div>

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
                            <span class="font-medium text-gray-800 dark:text-gray-200">Sistemas ERP, CRM y CMS</span>
                        </div>
                        <div class="flex items-center gap-3 bg-white dark:bg-gray-800/50 p-4 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700">
                            <div class="text-indigo-500"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg></div>
                            <span class="font-medium text-gray-800 dark:text-gray-200">Desarrollo móvil</span>
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



    <!--
    |------------------------------------------------------------------|
    |  ##########              SKILLS SECTION              ##########  |
    |------------------------------------------------------------------|
    -->

    <section id="skills" x-data="skillsComponent()" class="section-glass-panel relative z-10 py-24 transition-colors duration-300 overflow-hidden mx-3 md:mx-6 lg:mx-10 rounded-3xl mt-8 mb-8">
        <div class="max-w-screen-xl px-4 mx-auto relative">
            <div class="mb-12">
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white">Stack Tecnológico</h2>
                <div class="w-20 h-1.5 bg-indigo-600 mt-4 rounded-full"></div>
                <p class="text-gray-600 dark:text-gray-300 max-w-4xl mt-4 text-lg leading-relaxed">
                    Trabajo con una gran gama de tecnologías de desarrollo, tanto web (Portfolios, CRMs, ERPs y CMS) como en aplicaciones móviles y multiplataforma. Todo en <strong>completo fullstack</strong>.
                </p>
            </div>
            
            <!-- Grid Principal (6 Tarjetas) -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <template x-for="(skill, key) in skillsData" :key="key">
                    <div @click="openModal(key)" class="skill-card js-spotlight-card section-inner-card group cursor-pointer rounded-2xl p-6 transition-all duration-300 hover:shadow-lg hover:-translate-y-1 flex flex-col h-full relative overflow-hidden">
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
                        <div x-show="activeSkill?.image" class="mb-5 overflow-hidden rounded-xl h-32 md:h-40 bg-gray-100 dark:bg-gray-800">
                            <img :src="activeSkill?.image" :alt="activeSkill?.title" class="w-full h-full object-cover opacity-90">
                        </div>
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
                        <svg class="w-24 h-24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <rect x="4" y="4" width="7" height="7" rx="2" />
                            <rect x="13" y="13" width="7" height="7" rx="2" />
                            <circle cx="17" cy="7" r="2" />
                            <circle cx="7" cy="17" r="2" />
                        </svg>
                    </div>
                </div>

            </div>
        </div>
    </section>


    <!--
    |------------------------------------------------------------------|
    |  ##########             PROJECTS SECTION             ##########  |
    |------------------------------------------------------------------|
    -->
    <section id="projects" class="relative py-24 bg-transparent transition-colors duration-300">
        <div class="absolute top-0 right-0 -mr-20 -mt-20 w-72 h-72 bg-indigo-500/10 dark:bg-indigo-500/18 rounded-full blur-3xl pointer-events-none hidden lg:block"></div>
        <div class="absolute -bottom-24 -left-24 w-72 h-72 bg-indigo-500/10 dark:bg-indigo-500/18 rounded-full blur-3xl pointer-events-none hidden md:block"></div>
        <div class="max-w-screen-xl px-4 mx-auto relative z-10">
            <div class="mb-16">
                <h2 class="text-3xl font-extrabold text-gray-900 dark:text-white">Proyectos</h2>
                <div class="w-20 h-1.5 bg-indigo-600 mt-4 rounded-full"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($projects->take(3) as $project)
                    
                    <!-- Usamos nuestro nuevo componente de Card -->
                    <x-project-card :project="$project" />

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


    <!--
    |------------------------------------------------------------------|
    |  ##########             CONTACT SECTION              ##########  |
    |------------------------------------------------------------------|
    -->
    <section id="contact" class="section-glass-panel relative z-10 py-24 transition-colors duration-300 overflow-hidden mx-3 md:mx-6 lg:mx-10 rounded-3xl mt-8 mb-8">
        <div class="max-w-screen-md mx-auto px-4 relative z-10">
            
            <!-- Cabecera de la sección -->
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white tracking-tight">
                    Hablemos de tu proyecto
                </h2>
                <div class="w-24 h-1.5 bg-gradient-to-r from-indigo-500 to-purple-500 mt-5 rounded-full mx-auto"></div>
                
                @if (session('status'))
                    <div class="mt-6 p-4 bg-green-50 dark:bg-green-900/20 text-green-700 dark:text-green-300 rounded-xl border border-green-200 dark:border-green-800/50 flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        {{ session('status') }}
                    </div>
                @else
                    <p class="mt-5 text-lg text-gray-600 dark:text-gray-300 max-w-xl mx-auto">
                        Puedes escribirme <span class="font-semibold">sin compromiso</span> para contarme tu idea de proyecto: ya sea un <span class="font-semibold">portfolio profesional</span>, un <span class="font-semibold">CRM</span>, un <span class="font-semibold">ERP</span> o una <span class="font-semibold">app móvil</span> a medida. 
                        Cuéntame qué necesitas y te responderé con propuestas y próximos pasos claros.
                    </p>
                    <div class="mt-5 flex flex-wrap justify-center gap-2 text-xs font-semibold">
                        <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-indigo-50 text-indigo-700 border border-indigo-100 dark:bg-indigo-900/40 dark:text-indigo-200 dark:border-indigo-800/60 hover:scale-105 transition-transform">
                            <span class="w-1.5 h-1.5 rounded-full bg-indigo-500 animate-pulse"></span>
                            Portfolios
                        </span>
                        <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-100 dark:bg-emerald-900/40 dark:text-emerald-200 dark:border-emerald-800/60 hover:scale-105 transition-transform">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                            CRMs
                        </span>
                        <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-amber-50 text-amber-700 border border-amber-100 dark:bg-amber-900/40 dark:text-amber-200 dark:border-amber-800/60 hover:scale-105 transition-transform">
                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                            ERPs
                        </span>
                        <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-sky-50 text-sky-700 border border-sky-100 dark:bg-sky-900/40 dark:text-sky-200 dark:border-sky-800/60 hover:scale-105 transition-transform">
                            <span class="w-1.5 h-1.5 rounded-full bg-sky-500"></span>
                            Apps móviles
                        </span>
                    </div>
                @endif
            </div>

            <!-- Tarjeta del Formulario -->
            <div class="relative overflow-hidden">
                
                <form id="contactForm" action="{{ route('contact.store') }}" method="POST" class="space-y-6 relative z-10" novalidate>
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Nombre -->
                        <div class="space-y-1.5">
                            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nombre completo</label>
                            <input type="text" id="name" name="name" value="{{ old('name') }}" required 
                                placeholder="Ej. Ana García"
                                class="w-full rounded-xl border-gray-200 dark:border-gray-700 dark:bg-gray-800 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:border-indigo-500 focus:ring-indigo-500 transition-colors">
                        </div>
                        
                        <!-- Email -->
                        <div class="space-y-1.5">
                            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Correo electrónico</label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" required 
                                placeholder="hola@gmail.com"
                                class="w-full rounded-xl border-gray-200 dark:border-gray-700 dark:bg-gray-800 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:border-indigo-500 focus:ring-indigo-500 transition-colors">
                        </div>
                    </div>
                    
                    <!-- Mensaje -->
                    <div class="space-y-1.5">
                        <label for="content" class="block text-sm font-medium text-gray-700 dark:text-gray-300">¿En qué puedo ayudarte?</label>
                        <textarea id="content" name="content" rows="4" required 
                            placeholder="Me gustaría hablar contigo sobre el desarrollo de..."
                            class="w-full rounded-xl border-gray-200 dark:border-gray-700 dark:bg-gray-800 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:border-indigo-500 focus:ring-indigo-500 transition-colors resize-none">{{ old('content') }}</textarea>
                    </div>
                    
                    <!-- Botón Principal -->
                    <div class="pt-2">
                        <button type="submit" class="w-full sm:w-auto sm:min-w-[200px] flex justify-center items-center gap-2 px-8 py-3.5 bg-indigo-600 text-white font-medium rounded-xl hover:bg-indigo-700 active:scale-95 transition-all duration-200 shadow-md hover:shadow-lg shadow-indigo-500/20 ml-auto">
                            <span>Enviar mensaje</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </button>
                    </div>
                </form>

                <!-- Alternativa secundaria (Discreta) -->
                <div class="mt-8 pt-6 border-t border-gray-100 dark:border-gray-800/60 relative z-10 flex items-center justify-center">
                    <p class="text-sm text-gray-500 dark:text-gray-500 flex flex-wrap items-center justify-center gap-1.5 text-center">
                        <span>¿Prefieres usar el correo?</span> 
                        <a href="mailto:{{ env('APP_CONTACT_EMAIL') }}" class="group inline-flex items-center gap-1.5 font-medium text-gray-500 dark:text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">
                            <!-- El icono y el texto ahora estarán alineados al centro exacto entre sí -->
                            <x-icons.email class="w-5 h-5 transition-colors duration-300" />
                            <span>Contáctame por email</span>
                        </a>
                    </p>
                </div>

            </div>
        </div>
    </section>

@endsection



<!--
    |------------------------------------------------------------------|
    |  ##########               SCRIPTS JS                 ##########  |                
    |------------------------------------------------------------------|
-->
@push('scripts')
<script>
/* ================================================================
   HERO FLUID BACKGROUND — WebGL domain-warped fluid field
   Translated from hero-soft.jsx (FluidField component).
   Palette: --color-primary (mint) → --color-secondary (indigo).
   ================================================================ */
(function () {
    const canvas = document.getElementById('hero-fluid-canvas');
    if (!canvas) return;

    const gl = canvas.getContext('webgl', { premultipliedAlpha: false, antialias: true });
    if (!gl) return;

    const dpr = Math.min(window.devicePixelRatio || 1, 2);

    /** Altura estable para normalizar el scroll del shader sin jitter al mostrar/ocultar UI del navegador. */
    function layoutViewportCssHeight() {
        return Math.max(1, document.documentElement.clientHeight || window.innerHeight);
    }

    let resizeRaf = 0;
    function resize() {
        const rect = canvas.getBoundingClientRect();
        const cssW = Math.max(1, rect.width || window.innerWidth);
        const cssH = Math.max(1, rect.height || window.innerHeight);

        const bufW = Math.max(1, Math.floor(cssW * dpr));
        const bufH = Math.max(1, Math.floor(cssH * dpr));
        if (canvas.width !== bufW || canvas.height !== bufH) {
            canvas.width = bufW;
            canvas.height = bufH;
        }
        gl.viewport(0, 0, bufW, bufH);
    }

    function scheduleResize() {
        if (resizeRaf) return;
        resizeRaf = requestAnimationFrame(() => {
            resizeRaf = 0;
            resize();
        });
    }

    resize();
    window.addEventListener('resize', scheduleResize, { passive: true });
    if (window.visualViewport) {
        window.visualViewport.addEventListener('resize', scheduleResize, { passive: true });
    }

    /* ── Shaders ── */
    const vsSrc = `attribute vec2 a; void main(){ gl_Position = vec4(a, 0., 1.); }`;

    const fsSrc = `
        precision highp float;
        uniform vec2  u_res;
        uniform float u_time;
        uniform float u_dark;
        uniform float u_scroll; /* scrollY / innerHeight — pans the field vertically */

        float noise(vec2 p) {
            return fract(sin(dot(p, vec2(12.9898, 78.233))) * 43758.5453);
        }

        void main(){
            vec2 uv    = gl_FragCoord.xy / u_res.xy;
            float ratio = u_res.x / u_res.y;

            /* Offset vertical coordinate by scroll so the pattern pans with the page.
               WebGL's y-axis runs bottom→top (opposite to CSS), so we subtract:
               scrolling down increases scrollY → decreases p.y → samples lower
               in the virtual field → pattern moves up, matching page content. */
            vec2 p = uv;
            p.x   *= ratio;
            p.y   -= u_scroll;

            float t = u_time * 0.25;

            /* Domain warp — liquid flow */
            vec2 shift = p;
            for (float i = 1.0; i < 3.0; i++) {
                shift.x += 0.35 / i * sin(i * 1.8 * p.y + t);
                shift.y += 0.30 / i * cos(i * 1.8 * p.x + t);
            }

            /* Diagonal band: top-right → bottom-left */
            float diagonal = shift.x + shift.y * ratio;
            float target   = ratio * 1.0;
            float mask     = smoothstep(0.9, 0.0, abs(diagonal - target));

            /* Colour drift along the band */
            float mixer     = smoothstep(0.2, 0.8, uv.x + sin(t * 0.5) * 0.2);
            vec3  cA        = vec3(0.604, 0.820, 0.824);   /* --color-primary   #9ad1d2 */
            vec3  cB        = vec3(0.388, 0.400, 0.945);   /* --color-secondary #6366f1 */
            vec3  fluid     = mix(cA, cB, mixer);

            vec3  lightBg   = vec3(1.0, 1.0, 1.0);
            vec3  darkBg    = vec3(0.0941, 0.1020, 0.1216);
            vec3  bg        = mix(lightBg, darkBg, u_dark);
            vec3  color     = mix(bg, fluid, mask * 0.95);

            /* Subtle film grain */
            float grain = (noise(uv + fract(u_time)) - 0.5) * 0.05;
            color += grain;

            gl_FragColor = vec4(color, 1.0);
        }
    `;

    function mkShader(type, src) {
        const s = gl.createShader(type);
        gl.shaderSource(s, src);
        gl.compileShader(s);
        if (!gl.getShaderParameter(s, gl.COMPILE_STATUS)) {
            console.warn('[hero-fluid] shader error:', gl.getShaderInfoLog(s));
        }
        return s;
    }

    const prog = gl.createProgram();
    gl.attachShader(prog, mkShader(gl.VERTEX_SHADER,   vsSrc));
    gl.attachShader(prog, mkShader(gl.FRAGMENT_SHADER, fsSrc));
    gl.linkProgram(prog);
    gl.useProgram(prog);

    /* Full-screen quad */
    const buf = gl.createBuffer();
    gl.bindBuffer(gl.ARRAY_BUFFER, buf);
    gl.bufferData(gl.ARRAY_BUFFER, new Float32Array([
        -1,-1,  1,-1,  -1, 1,
        -1, 1,  1,-1,   1, 1,
    ]), gl.STATIC_DRAW);
    const aLoc = gl.getAttribLocation(prog, 'a');
    gl.enableVertexAttribArray(aLoc);
    gl.vertexAttribPointer(aLoc, 2, gl.FLOAT, false, 0, 0);

    const uRes    = gl.getUniformLocation(prog, 'u_res');
    const uTime   = gl.getUniformLocation(prog, 'u_time');
    const uDark   = gl.getUniformLocation(prog, 'u_dark');
    const uScroll = gl.getUniformLocation(prog, 'u_scroll');

    const t0    = performance.now();
    const speed = 0.06;

    /* Pause when tab is hidden to save GPU */
    let paused = false;
    document.addEventListener('visibilitychange', () => {
        paused = document.hidden;
        if (!paused) requestAnimationFrame(frame);
    });

    function frame() {
        if (paused) return;
        const t      = (performance.now() - t0) / 1000 * speed * 8.0;
        const isDark = document.documentElement.classList.contains('dark') ? 1 : 0;
        /* Normalize by innerHeight so one viewport-scroll = +1 in shader space.
           Reading scrollY inside rAF is non-blocking — no layout reflow. */
        const scroll = window.scrollY / Math.max(1, layoutViewportCssHeight());
        gl.uniform2f(uRes,    canvas.width, canvas.height);
        gl.uniform1f(uTime,   t);
        gl.uniform1f(uDark,   isDark);
        gl.uniform1f(uScroll, scroll);
        gl.drawArrays(gl.TRIANGLES, 0, 6);
        requestAnimationFrame(frame);
    }
    frame();
})();
/* ================================================================ */
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('contactForm');
        
        if (form) {
            form.addEventListener('submit', async function(e) {
                e.preventDefault();
                
                const submitBtn = form.querySelector('button[type="submit"]');
                const originalBtnText = submitBtn.innerHTML;
                
                form.querySelectorAll('.error-msg, .server-error-banner').forEach(el => el.remove());
                form.querySelectorAll('.border-red-500, .border-indigo-500').forEach(el => el.classList.remove('border-red-500', 'focus:border-red-500', 'focus:ring-red-500', 'border-indigo-500', 'focus:border-indigo-500', 'focus:ring-indigo-500', 'dark:border-indigo-400'));

                // Frontend Validation to prevent loading flicker on empty fields
                if (!form.checkValidity()) {
                    let firstInvalid = null;
                    const elements = form.elements;
                    for (let i = 0; i < elements.length; i++) {
                        const input = elements[i];
                        if (input.willValidate && !input.checkValidity()) {
                            if (!firstInvalid) firstInvalid = input;
                            input.classList.add('border-indigo-500', 'focus:border-indigo-500', 'focus:ring-indigo-500', 'dark:border-indigo-400');
                            const errorDiv = document.createElement('p');
                            errorDiv.className = 'error-msg mt-1.5';
                            errorDiv.setAttribute('role', 'alert');
                            
                            let errorMsg = 'Este campo es obligatorio.';
                            if (input.validity.typeMismatch) {
                                errorMsg = 'El formato no es válido.';
                            }

                            errorDiv.innerHTML = `
                                <span class="inline-flex items-center gap-1.5 rounded-md border border-indigo-200/70 bg-indigo-50/80 px-2 py-1 text-sm text-indigo-600 dark:border-indigo-500/20 dark:bg-indigo-950/20 dark:text-indigo-400">
                                    <svg class="h-4 w-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                                    </svg>
                                    <span>${errorMsg}</span>
                                </span>
                            `;
                            input.parentNode.appendChild(errorDiv);
                        }
                    }
                    if (firstInvalid) firstInvalid.focus();
                    return; // Detenemos aquí para no hacer fetch ni poner el spinner
                }

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
                                        input.classList.add('border-indigo-500', 'focus:border-indigo-500', 'focus:ring-indigo-500', 'dark:border-indigo-400');
                                        const errorDiv = document.createElement('p');
                                        errorDiv.className = 'error-msg mt-1.5';
                                        errorDiv.setAttribute('role', 'alert');
                                        errorDiv.innerHTML = `
                                            <span class="inline-flex items-center gap-1.5 rounded-md border border-indigo-200/70 bg-indigo-50/80 px-2 py-1 text-sm text-indigo-600 dark:border-indigo-500/20 dark:bg-indigo-950/20 dark:text-indigo-400">
                                                <svg class="h-4 w-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                                                </svg>
                                                <span>${errors[0]}</span>
                                            </span>
                                        `;
                                        input.parentNode.appendChild(errorDiv);
                                    } else {
                                        mostrarError(form, `Error en el campo "${field}": ${errors[0]}`);
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
                errorBanner.className = 'server-error-banner mb-6';
                errorBanner.setAttribute('role', 'alert');
                errorBanner.innerHTML = `
                    <div class="flex gap-3 rounded-xl border border-indigo-200/80 bg-indigo-50/60 px-4 py-3 dark:border-indigo-500/30 dark:bg-indigo-950/30">
                        <span class="flex shrink-0 items-center justify-center rounded-full bg-indigo-100 dark:bg-indigo-900/50 p-1.5" aria-hidden="true">
                            <svg class="h-5 w-5 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                            </svg>
                        </span>
                        <div class="min-w-0 flex-1">
                            <p class="text-sm font-semibold text-gray-800 dark:text-gray-100">Algo salió mal</p>
                            <p class="mt-1 text-sm text-gray-700 dark:text-gray-300 message-text"></p>
                        </div>
                    </div>
                `;
                errorBanner.querySelector('.message-text').textContent = mensaje;
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
                image: 'https://images.pexels.com/photos/1181675/pexels-photo-1181675.jpeg?auto=compress&cs=tinysrgb&w=800',
                icon: 'M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9',
                color: 'text-indigo-600 dark:text-indigo-400',
                bg: 'bg-indigo-50 dark:bg-indigo-900/30',
                description: 'Mi núcleo de trabajo diario. Monto webs de portfolio, tiendas online, ERPs(Gestión de recursos internos para negocios) y CRMs.(Sistemas internos para gestión de clientes).',
                technologies:[
                    { name: 'Laravel', badge: 'https://img.shields.io/badge/Laravel-FF2D20?style=flat&logo=laravel&logoColor=white', description: 'Mi framework principal de backend: Me permite desplegar webs sólidas en minutos. Lo utilizo a diario para gestionar autenticaciones seguras y orquestar toda la lógica de negocio de mis proyectos usando Eloquent ORM.' },
                    { name: 'PHP', badge: 'https://img.shields.io/badge/PHP-777BB4?style=flat&logo=php&logoColor=white', description: 'Como es estandar en desarrollo web, PHP es el motor de la mayoría de mis desarrollos backend. He evolucionado con el lenguaje, aprovechando su tipado fuerte en las últimas versiones para escribir código limpio, moderno y orientado a objetos.' },
                    { name: 'JavaScript', badge: 'https://img.shields.io/badge/JavaScript-F7DF1E?style=flat&logo=javascript&logoColor=black', description: 'Lo uso para dar vida a mis interfaces. Desde manipular el DOM de forma directa hasta consumir mis propias APIs asíncronas, es mi herramienta clave para crear una experiencia de usuario fluida.' },
                    { name: 'Tailwind CSS', badge: 'https://img.shields.io/badge/Tailwind_CSS-38B2AC?style=flat&logo=tailwind-css&logoColor=white', description: 'Mi framework CSS de cabecera. Es una mejora a simplemente usar CSS: Agiliza enormemente mi flujo de trabajo maquetando directamente en el HTML lo cual crea un código más limpio y mejor arquitectura. CSS todavía tiene sus usos, especialmente para elementos repetitivos/consistentes.' },
                    { name: 'HTML5', badge: 'https://img.shields.io/badge/HTML5-E34F26?style=flat&logo=html5&logoColor=white', description: 'La base de todo proyecto web. He usado HTML en todos mis proyectos web ( Aunque obviamente en proyectos con CMS no se usa apenas pues se programa mediante bloques, lo cual puede servir para proyectos rápidos y simples, pero no hay nada tan flexible y básico para diseñar web como HTML).' },
                    { name: 'CSS3', badge: 'https://img.shields.io/badge/CSS3-1572B6?style=flat&logo=css3&logoColor=white', description: 'Aunque use frameworks CSS, el uso de CSS nativo sigue teniendo cavida para los detalles precisos o cuando se repite un estilo en varios elementos. Además también lo he trabajado en proyectos no tan modernos mientras trabajé con empresas de ERP.' },
                    { name: 'jQuery', badge: 'https://img.shields.io/badge/jQuery-0769AD?style=flat&logo=jquery&logoColor=white', description: 'Me ha salvado la vida al tomar el relevo de proyectos heredados. Aún lo utilizo para dar mantenimiento a sistemas más antiguos o implementar scripts rápidos de validación.' },
                    { name: 'Bootstrap', badge: 'https://img.shields.io/badge/Bootstrap-7952B3?style=flat&logo=bootstrap&logoColor=white', description: 'Mi opción rápida y segura cuando necesito levantar el panel de administración de un CRM o un dashboard interno. Me permite entregar prototipos funcionales y estables en tiempo récord.' }
                ]
            },
            movil: {
                title: 'Desarrollo Multiplataforma & Móvil',
                image: 'https://www.addevice.io/storage/ckeditor/uploads/images/65f840d316353_mobile.app.development.1920.1080.png',
                icon: 'M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z',
                color: 'text-green-600 dark:text-green-400',
                bg: 'bg-green-50 dark:bg-green-900/30',
                description: 'Desarrollo apps nativas para Android que luego también puedo adaptar a dispositivos de Apple (IOS). Además he diseñado videojuegos en Unity para móviles y VR.',
                technologies:[
                    { name: 'Kotlin', badge: 'https://img.shields.io/badge/Kotlin-7F52FF?style=flat&logo=kotlin&logoColor=white', description: 'Es el lenguaje recomendado para el desarrollo móvil y lo he estado usando intensivamente al desarrollar apps nativas como mi aplicación "Platorama". Es uno de los lenguajes con los que más familiarizado estoy al haber pasado mucho tiempo desarrollando en Android Studio.' },
                    { name: 'Android Studio', badge: 'https://img.shields.io/badge/Android%20Studio-3DDC84?style=flat&logo=android-studio&logoColor=white', description: 'Mi centro de operaciones para crear apps móviles. Aquí es donde gestiono todo el ciclo de vida: desde el diseño de la interfaz y la inyección de dependencias, hasta el perfilado de rendimiento y la compilación final.' },
                    { name: 'C++', badge: 'https://img.shields.io/badge/C++-00599C?style=flat&logo=c%2B%2B&logoColor=white', description: 'C++ es un lenguaje pilar de la programación y actualmente sigue teniendo uso para programación a bajo nivel. Aunque no estoy tan familiarizado con él, sí que lo he estudiado y estado usando durante un tiempo para diseñar juegos en Unreal Engine.' },
                    { name: 'C#', badge: 'https://img.shields.io/badge/C%23-239120?style=flat&logo=csharp&logoColor=white', description: 'El lenguaje que utilizo principalmente como motor lógico detrás de Unity. Con él he programado comportamientos complejos, físicas y herramientas personalizadas orientadas a objetos.' },
                    { name: 'Unity', badge: 'https://img.shields.io/badge/Unity-100000?style=flat&logo=unity&logoColor=white', description: 'Mi motor de desarrollo de confianza para desarrollar apps interactivas y videojuegos. Lo he utilizado para desarrollar tanto videojuegos (de móvil y PC) como simulaciones y entornos inmersivos de realidad virtual (VR).' }
                ]
            },
            ecommerce: {
                title: 'E-commerce, ERPs & CMS',
                image: 'https://images.pexels.com/photos/4968391/pexels-photo-4968391.jpeg?auto=compress&cs=tinysrgb&w=800',
                icon: 'M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z',
                color: 'text-pink-600 dark:text-pink-400',
                bg: 'bg-pink-50 dark:bg-pink-900/30',
                description: 'Digitalizo negocios implementando tiendas online y desarrollando programas internos de gestión de los recursos (ERP) y clientes (CRM).',
                technologies:[
                    { name: 'PrestaShop', badge: 'https://img.shields.io/badge/PrestaShop-df0067?style=flat&logo=prestashop&logoColor=white', description: 'Lo utilizo para montar tiendas online rápidamente con un sistema ya establecido. He trabajado con él durante mi trabajo como programador en "Al Rescate". No solo lo he configuradp, también he desarrollado módulos a medida en PHP y adaptado plantillas para cubrir flujos de venta B2B y B2C muy específicos.' },
                    { name: 'Dolibarr ERP', badge: 'https://img.shields.io/badge/Dolibarr_ERP-2980B9?style=flat', description: 'He usado este sistema para digitalizar la gestión de empresas durante mi trabajo en "Al rescate". Lo he usado para darle a clientes el control total de facturación, almacén e incluso lo he sincronizado por API con sus tiendas web.' },
                    { name: 'WooCommerce', badge: 'https://img.shields.io/badge/WooCommerce-96588A?style=flat&logo=woocommerce&logoColor=white', description: 'Mi elección para e-commerce más ágiles e integrados. Podeis ver un ejemplo de mi trabajo con WooCommerce en la web "LaBichaTattoo.es". Me he metido a fondo en su código modificando hooks, creando pasarelas de pago personalizadas y optimizando el proceso de checkout.' },
                    { name: 'WordPress', badge: 'https://img.shields.io/badge/WordPress-21759B?style=flat&logo=wordpress&logoColor=white', description: 'Mientras que los CMS no son una buena opción para proyectos grandes o complejos, para el desarrollo de webs medianamente sencillas WordPress es una herramienta útil para diseños super rápidos y autogestionables por el usuario final.' }
                ]
            },
            bbdd: {
                title: 'Bases de Datos (SGBD)',
                image: 'https://images.pexels.com/photos/669615/pexels-photo-669615.jpeg?auto=compress&cs=tinysrgb&w=800',
                icon: 'M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4',
                color: 'text-blue-600 dark:text-blue-400',
                bg: 'bg-blue-50 dark:bg-blue-900/30',
                description: 'Todo proyecto complejo en el que trabajo requiere gestión de datos: Diseño estructuras de datos buscando los mejores patrones de diseño para asegurar la integridad y escalabilidad de los datos.',
                technologies:[
                    { name: 'MySQL', badge: 'https://img.shields.io/badge/MySQL-4479A1?style=flat&logo=mysql&logoColor=white', description: 'El pilar de los datos de mis proyectos web. Diseño esquemas relacionales desde cero, optimizo índices para acelerar búsquedas y lanzo consultas SQL crudas complejas para reportes internos.' },
                    { name: 'MariaDB', badge: 'https://img.shields.io/badge/MariaDB-003545?style=flat&logo=mariadb&logoColor=white', description: 'La alternativa de código abierto y altísimo rendimiento que suelo montar cuando configuro mis propios servidores Linux, dándome total tranquilidad en la gestión de miles de registros.' },
                    { name: 'Firebase', badge: 'https://img.shields.io/badge/Firebase-FFCA28?style=flat&logo=firebase&logoColor=black', description: 'He usado mucho Firebase en proyectos de desarrollo móvil como en la red social que desarrollé: "Platorama". Además utilizo su base de datos NoSQL para sincronización en tiempo real, autenticación de usuarios y envíos masivos de notificaciones Push.' },
                    { name: 'SQLite', badge: 'https://img.shields.io/badge/SQLite-003B57?style=flat&logo=sqlite&logoColor=white', description: 'Mi comodín ligero. Lo utilizo para el almacenamiento local persistente en mis apps Android (para que funcionen offline) y para ejecutar baterías de testing ultrarrápidas en Laravel.' },
                    { name: 'phpMyAdmin', badge: 'https://img.shields.io/badge/phpMyAdmin-6C78AF?style=flat', description: 'La herramienta visual clásica a la que recurro en entornos de hosting compartido para hacer volcados rápidos de datos o gestionar privilegios de usuarios directamente en producción.' },
                    { name: 'HeidiSQL', badge: 'https://img.shields.io/badge/HeidiSQL-FFD43B?style=flat', description: 'El cliente SQL que abro cada día en mi equipo. Me permite conectarme remotamente a las bases de datos de mis clientes para lanzar scripts de mantenimiento o hacer migraciones masivas.' }
                ]
            },
            infra: {
                title: 'Infraestructura & DevOps',
                image: 'https://images.pexels.com/photos/1181354/pexels-photo-1181354.jpeg?auto=compress&cs=tinysrgb&w=800',
                icon: 'M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2',
                color: 'text-orange-600 dark:text-orange-400',
                bg: 'bg-orange-50 dark:bg-orange-900/30',
                description: 'No solo escribo código, también lo pongo en producción. Publico las aplicaciones, gestiono los servidores, el control de versiones y el posicionamiento en motores de búsqueda (SEO).',
                technologies:[
                    { name: 'Docker', badge: 'https://img.shields.io/badge/Docker-2496ED?style=flat&logo=docker&logoColor=white', description: 'Lo uso para acabar con el problema de "en mi máquina funciona" cuando pretendo compartir el proyecto o migrarlo a un servidor. Containerizando con entornos como Sail, garantizo que el código se comporte exactamente igual en mi PC que en el servidor.' },
                    { name: 'Nginx', badge: 'https://img.shields.io/badge/Nginx-009639?style=flat&logo=nginx&logoColor=white', description: 'El motor de mis servidores VPS, esta web y la mayoría de webs que he hecho las hosteo en mi servidor privado con Nginx. Lo configuro como proxy inverso para despachar aplicaciones web y soportar grandes picos de concurrencia de forma supereficiente.' },
                    { name: 'Apache', badge: 'https://img.shields.io/badge/Apache-D22128?style=flat&logo=apache&logoColor=white', description: 'Aunque actualmente prefiera usar Nginx sobre Apache por ser más moderno, veloz y optimizado, he usado mucho Apache en mi tiempo desarrollando en "Al Rescate" usando XAMPP y aprecio que todavía tiene algunas ventajas como servidor, especialmente para contenido dinámico y complejo.' },
                    { name: 'Git', badge: 'https://img.shields.io/badge/Git-F05032?style=flat&logo=git&logoColor=white', description: 'Es la herramienta que más uso pues es fundamental en cualquier proyecto de desarrollo de software: Me permite trabajar con ramas estructuradas, experimentar sin romper nada y contar con puntos de guardado.' },
                    { name: 'GitHub', badge: 'https://img.shields.io/badge/GitHub-181717?style=flat&logo=github&logoColor=white', description: 'El hogar de mi código. Además de mis repositorios Git en la nube, lo utilizo para establecer flujos de trabajo profesionales donde puedo trabajar con otros desarrolladores, automatizar los despliegues a producción (CI/CD) o participar en proyectos públicos.' },
                    { name: 'Postman', badge: 'https://img.shields.io/badge/Postman-FF6C37?style=flat&logo=postman&logoColor=white', description: 'Mi banco de pruebas en proyectos web. Antes de escribir una sola línea en el frontend, lo uso para estresar y validar mis APIs, asegurándome de que cada endpoint responda con la data exacta.' },
                    { name: 'Bash', badge: 'https://img.shields.io/badge/Terminal/Bash-4EAA25?style=flat&logo=gnu-bash&logoColor=white', description: 'Paso gran parte de mi tiempo conectado a servidores Linux por SSH a través de Bash. En la terminal, actualizo dependencias, administro el contenido o ejecuto mis propios scripts para automatizar rutinas pesadas, como los sistemas de copias de seguridad.' },
                    { name: 'FileZilla', badge: 'https://img.shields.io/badge/FileZilla-BF0000?style=flat&logo=filezilla&logoColor=white', description: 'Mi herramienta SFTP: Aunque gestionar servidores por Bash suele ser suficiente, a menudo uso Filezilla para conectarme de forma rápida por SFTP a servidores para comprobarlos o administrar el contenido de forma rápida si no se trata de muchos archivos (En cuyo caso preferiría subir un .zip y descomprimirlo con bash).' }
                ]
            },
            arquitectura: {
                title: 'Arquitectura y Patrones',
                image: 'https://miro.medium.com/v2/resize:fit:1200/1*RiuRKtGDcgBQgoI9-JE-kg.jpeg',
                icon: 'M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
                color: 'text-purple-600 dark:text-purple-400',
                bg: 'bg-purple-50 dark:bg-purple-900/30',
                description: 'La diferencia entre un código que "funciona" y uno "profesional". Me tomo en serio estudiar y aplicar principios de ingeniería para crear software escalable y libre de deuda técnica.',
                technologies:[
                    { name: 'Clean Architecture', badge: 'https://img.shields.io/badge/Clean_Architecture-607D8B?style=flat', description: 'Me permite tener código separado por responsabilidades y escalable. Aislando el núcleo del negocio de la infraestructura consigo que cambiar de base de datos o framework en el futuro no implique reescribir toda la aplicación.' },
                    { name: 'SOLID Principles', badge: 'https://img.shields.io/badge/SOLID_Principles-607D8B?style=flat', description: 'Considero que son principios básicos que todo programador debe conocer para un buen código. Aplicar estos principios permite escribir un código modular y testeable, que no se convierta en una pesadilla cuando haya que hacerle mantenimiento años después.' },
                    { name: 'Design Patterns', badge: 'https://img.shields.io/badge/Design_Patterns-607D8B?style=flat', description: 'No reinvento la rueda. Ante problemas de diseño recurrentes, aplico patrones probados (Observer, Factory, Repository, Singleton) para que mis soluciones sean elegantes y entendibles por otros.' },
                    { name: 'MVVM', badge: 'https://img.shields.io/badge/MVVM-607D8B?style=flat', description: 'La arquitectura que estructura mis apps móviles modernas como "Platorama". Desacoplar la interfaz gráfica de la lógica de negocio me ha permitido tener interfaces reactivas, predecibles y fáciles de probar.' },
                    { name: 'REST APIs', badge: 'https://img.shields.io/badge/REST_APIs-607D8B?style=flat', description: 'Es como comunico mis sistemas. Me aseguro de diseñar APIs sin estado y sumamente lógicas, utilizando los verbos HTTP correctos, tokens JWT y códigos de estado semánticos en cada respuesta.' }
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
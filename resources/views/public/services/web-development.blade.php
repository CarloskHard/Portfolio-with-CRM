@extends('layouts.public')

@section('title', 'Desarrollo Web | Carlos Codex')
@section('meta_description', 'Creo webs rápidas y orientadas a conversión para negocios: desde landing pages hasta plataformas personalizadas con panel de gestión.')

@section('content')
<section class="relative py-24 mx-3 md:mx-6 lg:mx-10">
    <div class="max-w-screen-xl mx-auto px-4">
        <div class="rounded-3xl border border-gray-200 dark:border-gray-800 bg-white/90 dark:bg-gray-900/85 p-8 md:p-12 shadow-sm">
            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-indigo-600 dark:text-indigo-400">Servicio</p>
            <h1 class="mt-3 text-3xl md:text-5xl font-extrabold text-gray-900 dark:text-white leading-tight">
                Desarrollo web para convertir visitas en clientes
            </h1>
            <p class="mt-5 text-lg text-gray-600 dark:text-gray-300 max-w-3xl">
                Diseño y desarrollo sitios web y plataformas a medida para negocios que necesitan vender mejor, automatizar tareas y transmitir confianza desde el primer clic.
            </p>
            <div class="mt-8 flex flex-wrap gap-3">
                <a href="{{ route('home', ['service' => 'web-development']) }}#contact" class="inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-indigo-600 text-white font-semibold hover:bg-indigo-700 transition-colors">
                    Solicitar propuesta web
                </a>
                <a href="{{ route('public.projects') }}" class="inline-flex items-center gap-2 px-6 py-3 rounded-xl border border-gray-300 dark:border-gray-700 text-gray-800 dark:text-gray-200 font-semibold hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                    Ver proyectos
                </a>
            </div>
        </div>
    </div>
</section>

<section class="mx-3 md:mx-6 lg:mx-10 mb-8">
    <div class="max-w-screen-xl mx-auto px-4 grid grid-cols-1 lg:grid-cols-2 gap-6">
        <article class="rounded-2xl border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900 p-7">
            <h2 class="text-xl font-bold text-gray-900 dark:text-white">Problemas que resuelvo</h2>
            <ul class="mt-4 space-y-3 text-gray-600 dark:text-gray-300">
                <li>- Web lenta o desactualizada que no genera contactos.</li>
                <li>- Proceso de captación sin embudo ni métricas claras.</li>
                <li>- Falta de panel interno para gestionar contenido o leads.</li>
                <li>- Dependencia de herramientas inconexas que hacen perder tiempo.</li>
            </ul>
        </article>
        <article class="rounded-2xl border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900 p-7">
            <h2 class="text-xl font-bold text-gray-900 dark:text-white">Qué incluye el servicio</h2>
            <ul class="mt-4 space-y-3 text-gray-600 dark:text-gray-300">
                <li>- Arquitectura y alcance alineados a tus objetivos de negocio.</li>
                <li>- Desarrollo frontend/backend con enfoque en rendimiento y SEO técnico.</li>
                <li>- Integraciones con formularios, CRM, pasarelas o APIs externas.</li>
                <li>- Soporte de lanzamiento y mejoras iterativas post-publicación.</li>
            </ul>
        </article>
    </div>
</section>

<section class="mx-3 md:mx-6 lg:mx-10 mb-8">
    <div class="max-w-screen-xl mx-auto px-4 rounded-2xl border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900 p-7 md:p-10">
        <h2 class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-white">Proceso de trabajo</h2>
        <div class="mt-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 text-sm">
            <div class="rounded-xl border border-gray-200 dark:border-gray-700 p-4">
                <p class="text-indigo-600 dark:text-indigo-400 font-semibold">01 · Diagnóstico</p>
                <p class="mt-2 text-gray-600 dark:text-gray-300">Defino objetivos, público y alcance realista del proyecto.</p>
            </div>
            <div class="rounded-xl border border-gray-200 dark:border-gray-700 p-4">
                <p class="text-indigo-600 dark:text-indigo-400 font-semibold">02 · Propuesta</p>
                <p class="mt-2 text-gray-600 dark:text-gray-300">Entrego roadmap, tiempos y entregables para validar sin sorpresas.</p>
            </div>
            <div class="rounded-xl border border-gray-200 dark:border-gray-700 p-4">
                <p class="text-indigo-600 dark:text-indigo-400 font-semibold">03 · Construcción</p>
                <p class="mt-2 text-gray-600 dark:text-gray-300">Desarrollo por bloques con revisiones periódicas y feedback continuo.</p>
            </div>
            <div class="rounded-xl border border-gray-200 dark:border-gray-700 p-4">
                <p class="text-indigo-600 dark:text-indigo-400 font-semibold">04 · Lanzamiento</p>
                <p class="mt-2 text-gray-600 dark:text-gray-300">Publicación, medición inicial y plan de mejoras con foco en resultados.</p>
            </div>
        </div>
    </div>
</section>

<section class="mx-3 md:mx-6 lg:mx-10 mb-24">
    <div class="max-w-screen-xl mx-auto px-4 grid grid-cols-1 lg:grid-cols-3 gap-6">
        <article class="lg:col-span-2 rounded-2xl border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900 p-7">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Preguntas frecuentes</h2>
            <div class="mt-6 space-y-5 text-gray-600 dark:text-gray-300">
                <div>
                    <h3 class="font-semibold text-gray-900 dark:text-white">¿Trabajas con webs nuevas o rediseños?</h3>
                    <p class="mt-1">Ambas opciones. Primero evalúo si conviene optimizar lo existente o reconstruir para ganar rendimiento y escalabilidad.</p>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-900 dark:text-white">¿Incluyes mantenimiento?</h3>
                    <p class="mt-1">Sí, puedo incluir soporte evolutivo para mejoras, contenidos y nuevas integraciones.</p>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-900 dark:text-white">¿Cómo se define el precio?</h3>
                    <p class="mt-1">Según alcance, complejidad e integraciones. Te doy una propuesta clara con fases y entregables.</p>
                </div>
            </div>
        </article>
        <aside class="rounded-2xl border border-indigo-200/70 dark:border-indigo-800 bg-indigo-50/70 dark:bg-indigo-900/20 p-7">
            <h2 class="text-xl font-bold text-gray-900 dark:text-white">Listo para empezar</h2>
            <p class="mt-3 text-gray-700 dark:text-gray-300">Cuéntame qué necesitas y te propongo el camino más corto para llevarlo a producción.</p>
            <a href="{{ route('home', ['service' => 'web-development']) }}#contact" class="mt-6 inline-flex items-center justify-center w-full px-5 py-3 rounded-xl bg-indigo-600 text-white font-semibold hover:bg-indigo-700 transition-colors">
                Hablar sobre mi web
            </a>
        </aside>
    </div>
</section>
@endsection

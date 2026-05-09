<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full antialiased">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <title>404 | Página no encontrada</title>
    <meta name="description" content="La página que buscas no se ha encontrado.">

    @vite(['resources/css/app.css'])

    <script>
        if (localStorage['color-theme'] === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
</head>
<body class="h-full bg-gray-50 text-gray-900 dark:bg-gray-950 dark:text-gray-100">
    <main class="relative isolate flex min-h-screen items-center justify-center overflow-hidden px-6 py-16 sm:px-8">
        <div class="pointer-events-none absolute inset-0 -z-10">
            <div class="absolute left-1/2 top-20 h-72 w-72 -translate-x-1/2 rounded-full bg-indigo-500/20 blur-3xl dark:bg-indigo-400/15"></div>
            <div class="absolute bottom-0 left-0 h-64 w-64 rounded-full bg-fuchsia-400/10 blur-3xl dark:bg-fuchsia-500/10"></div>
            <div class="absolute right-0 top-1/3 h-64 w-64 rounded-full bg-cyan-400/10 blur-3xl dark:bg-cyan-500/10"></div>
        </div>

        <section class="w-full max-w-xl rounded-3xl border border-gray-200/70 bg-white/80 p-8 shadow-2xl shadow-gray-200/50 backdrop-blur-xl dark:border-white/10 dark:bg-white/5 dark:shadow-black/40 sm:p-10">
            <p class="inline-flex items-center gap-2 rounded-full border border-gray-200 bg-white px-3 py-1 text-xs font-semibold uppercase tracking-[0.14em] text-gray-500 dark:border-white/10 dark:bg-white/10 dark:text-gray-300">
                <span class="h-1.5 w-1.5 rounded-full bg-indigo-500"></span>
                Error 404
            </p>

            <h1 class="mt-6 text-balance text-4xl font-semibold tracking-tight text-gray-950 dark:text-white sm:text-5xl">
                Esta página no existe.
            </h1>

            <p class="mt-4 text-pretty text-base leading-relaxed text-gray-600 dark:text-gray-300">
                El enlace puede estar desactualizado, haberse movido o tener un error tipográfico. Vuelve a la página de inicio para continuar navegando.
            </p>

            <div class="mt-8 flex flex-wrap items-center gap-3">
                <a href="{{ route('home') }}"
                   class="inline-flex items-center justify-center rounded-xl bg-gray-900 px-5 py-2.5 text-sm font-medium text-white transition hover:bg-gray-700 focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500 dark:bg-white dark:text-gray-900 dark:hover:bg-gray-200">
                    Ir al inicio
                </a>
            </div>
        </section>
    </main>
</body>
</html>

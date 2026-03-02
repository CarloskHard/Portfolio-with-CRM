@extends('layouts.public')

@section('title', 'Proyectos')

@section('content')
<!-- Añadido pt-28 (y lg:pt-36) para evitar que el header fijo tape el contenido -->
<div class="max-w-screen-xl px-4 mx-auto pt-28 pb-16 lg:pt-36 min-h-screen">
    
    <div class="text-center mb-16">
        <h1 class="text-4xl font-extrabold tracking-tight text-gray-900 dark:text-white">Portfolio Completo</h1>
        <p class="mt-4 text-lg text-gray-500 dark:text-gray-400">Explora todos mis trabajos, experimentos y desarrollos.</p>
        <div class="w-24 h-1 bg-indigo-600 mx-auto mt-6 rounded"></div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
        @forelse($projects as $project)
            <!-- Usamos componente de Card -->
            <x-project-card :project="$project" />
        @empty
            <div class="col-span-full text-center py-12">
                <p class="text-gray-500 dark:text-gray-400 text-lg">No hay proyectos públicos para mostrar en este momento.</p>
            </div>
        @endforelse
    </div>

    <div class="mt-12">
        {{ $projects->links() }}
    </div>
</div>
@endsection
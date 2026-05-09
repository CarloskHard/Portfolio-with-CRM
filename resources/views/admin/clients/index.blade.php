<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Gestión de Clientes') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex justify-end mb-4">
                <a href="{{ route('clients.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                    + Nuevo Cliente
                </a>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-100 text-gray-600 uppercase text-sm leading-normal">
                                <!-- HEADER ORDENABLE: NOMBRE COMERCIAL -->
                                <th class="py-3 px-6 text-left cursor-pointer hover:bg-gray-200 transition select-none group">
                                    @php
                                        $isSortingName = request('sort') === 'commercial_name';
                                        $currentDirection = request('direction', 'asc');
                                        
                                        // Si ya estamos ordenando por nombre y es ASC, el siguiente será DESC. Si no, ASC.
                                        $nextDirection = ($isSortingName && $currentDirection === 'asc') ? 'desc' : 'asc';
                                        
                                        // Generamos la URL manteniendo los filtros de tipo y búsqueda si los hubiera
                                        $urlName = request()->fullUrlWithQuery([
                                            'sort' => 'commercial_name',
                                            'direction' => $nextDirection
                                        ]);
                                    @endphp

                                    <a href="{{ $urlName }}" class="flex items-center gap-1" title="Ordenar alfabéticamente">
                                        Nombre Comercial
                                        
                                        @if($isSortingName)
                                            @if($currentDirection === 'asc')
                                                <!-- A-Z (Flecha Arriba) -->
                                                <svg class="w-4 h-4 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l4 4m-4-4v12" /></svg>
                                            @else
                                                <!-- Z-A (Flecha Abajo) -->
                                                <svg class="w-4 h-4 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h9m5-4v12m0 0l-4-4m4 4l4-4" /></svg>
                                            @endif
                                        @else
                                            <!-- Icono neutro (Gris) -->
                                            <svg class="w-4 h-4 text-gray-300 group-hover:text-gray-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4" /></svg>
                                        @endif
                                    </a>
                                </th>
                                
                                <!-- HEADER FILTRABLE: TIPO -->
                                <th class="py-3 px-6 text-left cursor-pointer hover:bg-gray-200 transition select-none">
                                    @php
                                        // Lógica del ciclo: All -> Company -> Individual -> All
                                        $currentType = request('type');
                                        $nextType = match($currentType) {
                                            null => 'company',
                                            'company' => 'individual',
                                            'individual' => null,
                                            default => null
                                        };
                                        // Generamos la URL manteniendo otros parámetros (como la página)
                                        $url = request()->fullUrlWithQuery(['type' => $nextType]);
                                    @endphp
                                    
                                    <a href="{{ $url }}" class="flex items-center gap-1 group" title="Clic para filtrar">
                                        Tipo
                                        <!-- Icono de Filtro (Cambia según estado) -->
                                        @if($currentType === 'company')
                                            <span class="text-blue-600 bg-blue-100 px-1 rounded text-[10px] lowercase">Empresas</span>
                                            <svg class="w-4 h-4 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" /></svg>
                                        @elseif($currentType === 'individual')
                                            <span class="text-green-600 bg-green-100 px-1 rounded text-[10px] lowercase">Partic.</span>
                                            <svg class="w-4 h-4 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" /></svg>
                                        @else
                                            <!-- Icono gris (inactivo) -->
                                            <svg class="w-4 h-4 text-gray-300 group-hover:text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" /></svg>
                                        @endif
                                    </a>
                                </th>

                                <!-- HEADER ORDENABLE: PROYECTOS -->
                                <th class="py-3 px-6 text-center cursor-pointer hover:bg-gray-200 transition select-none">
                                    @php
                                        // Lógica del Sort: Toggle DESC <-> ASC
                                        $isSorting = request('sort') === 'projects_count';
                                        $currentDirection = request('direction', 'desc');
                                        $nextDirection = ($isSorting && $currentDirection === 'desc') ? 'asc' : 'desc';
                                        
                                        $url = request()->fullUrlWithQuery([
                                            'sort' => 'projects_count',
                                            'direction' => $nextDirection
                                        ]);
                                    @endphp

                                    <a href="{{ $url }}" class="flex items-center justify-center gap-1 group" title="Clic para ordenar">
                                        Proyectos
                                        @if($isSorting)
                                            @if($currentDirection === 'desc')
                                                <!-- Icono Flecha Abajo (Mayor a menor) -->
                                                <svg class="w-4 h-4 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                                            @else
                                                <!-- Icono Flecha Arriba (Menor a mayor) -->
                                                <svg class="w-4 h-4 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" /></svg>
                                            @endif
                                        @else
                                            <!-- Icono neutro -->
                                            <svg class="w-4 h-4 text-gray-300 group-hover:text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4" /></svg>
                                        @endif
                                    </a>
                                </th>

                                <th class="py-3 px-6 text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600 text-sm font-light">
                            @foreach($clients as $client)
                            @php $projectsRowId = 'projects-row-'.$client->id; @endphp
                            <tr
                                class="border-b border-gray-200 hover:bg-gray-100 cursor-pointer"
                                onclick="window.location='{{ route('clients.edit', $client) }}'">
                                <td class="py-3 px-6 text-left whitespace-nowrap font-medium">
                                    <div class="flex items-center gap-2">
                                        <button
                                            type="button"
                                            id="toggle-{{ $projectsRowId }}"
                                            class="inline-flex h-6 w-6 items-center justify-center text-gray-600 hover:text-indigo-600 transition-colors"
                                            title="Mostrar proyectos"
                                            aria-label="Mostrar proyectos"
                                            onclick="event.stopPropagation(); const row = document.getElementById('{{ $projectsRowId }}'); const icon = document.getElementById('toggle-icon-{{ $projectsRowId }}'); row.classList.toggle('hidden'); icon.classList.toggle('rotate-90')">
                                            <svg id="toggle-icon-{{ $projectsRowId }}" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                            </svg>
                                        </button>
                                        <span>{{ $client->commercial_name }}</span>
                                    </div>
                                </td>
                                <td class="py-3 px-6 text-left">
                                    <span class="px-3 py-1 rounded-full text-xs {{ $client->type == 'company' ? 'bg-blue-200 text-blue-800' : 'bg-green-200 text-green-800' }}">
                                        {{ $client->type == 'company' ? 'Empresa' : 'Particular' }}
                                    </span>
                                </td>
                                <td class="py-3 px-6 text-center">
                                    {{ $client->projects_count }}
                                </td>
                                <td class="py-3 px-6 text-center">
                                    <div class="flex item-center justify-center" onclick="event.stopPropagation()">
                                        <a href="{{ route('clients.edit', $client) }}" class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                            </svg>
                                        </a>
                                        <form action="{{ route('clients.destroy', $client) }}" method="POST" class="inline">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="w-4 transform hover:text-red-500 hover:scale-110" onclick="return confirm('¿Borrar este cliente?')">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            <tr id="{{ $projectsRowId }}" class="hidden bg-gray-50">
                                <td colspan="4" class="py-3 px-6">
                                    @if($client->projects->count() > 0)
                                        <div class="pl-8 md:pl-10">
                                            <div class="text-xs uppercase tracking-wide text-gray-500 mb-2">Proyectos</div>
                                            <div class="space-y-2">
                                            @foreach($client->projects as $project)
                                                <a
                                                    href="{{ route('projects.edit', $project) }}"
                                                    class="group flex items-center justify-between rounded-md px-2 py-1.5 hover:bg-indigo-50"
                                                    onclick="event.stopPropagation()">
                                                    <span class="flex items-center gap-2 text-sm text-gray-700 group-hover:text-indigo-700">
                                                        <span class="text-gray-400">└─</span>
                                                        <span>{{ $project->title }}</span>
                                                    </span>
                                                    <span class="px-2 py-0.5 rounded-full text-[11px] font-semibold
                                                        {{ $project->visibility === 'public' ? 'bg-green-100 text-green-700' : '' }}
                                                        {{ $project->visibility === 'private' ? 'bg-amber-100 text-amber-700' : '' }}
                                                        {{ $project->visibility === 'draft' ? 'bg-gray-200 text-gray-700' : '' }}">
                                                        {{ $project->visibility === 'public' ? 'Publico' : ($project->visibility === 'private' ? 'Privado' : 'Borrador') }}
                                                    </span>
                                                </a>
                                            @endforeach
                                            </div>
                                        </div>
                                    @else
                                        <div class="pl-8 md:pl-10">
                                            <span class="text-sm text-gray-500 italic">Este cliente no tiene proyectos asociados.</span>
                                        </div>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="mt-4">{{ $clients->links() }}</div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
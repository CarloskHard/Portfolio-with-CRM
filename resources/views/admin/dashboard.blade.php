<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Panel de Administración') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Resumen de Estadísticas -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <!-- Tarjeta Proyectos -->
                <a href="{{ route('projects.index') }}" class="block bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 transition hover:shadow-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <div class="text-gray-900 text-xl font-bold">Proyectos</div>
                    <div class="text-3xl text-indigo-600 font-extrabold mt-2">
                        {{ \App\Models\Project::count() }}
                    </div>
                </a>

                <!-- Tarjeta Mensajes -->
                <a href="{{ route('messages.index') }}" class="block bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 transition hover:shadow-md focus:outline-none focus:ring-2 focus:ring-green-500">
                    <div class="text-gray-900 text-xl font-bold">Mensajes Nuevos</div>
                    <div class="text-3xl text-green-600 font-extrabold mt-2">
                        {{ \App\Models\Message::where('is_read', false)->count() }}
                    </div>
                </a>

                <!-- Tarjeta Tecnologías -->
                <a href="{{ route('clients.index') }}" class="block bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 transition hover:shadow-md focus:outline-none focus:ring-2 focus:ring-purple-500">
                    <div class="text-gray-900 text-xl font-bold">Clientes</div>
                    <div class="text-3xl text-purple-600 font-extrabold mt-2">
                        {{ \App\Models\Client::count() }}
                    </div>
                </a>
            </div>

        </div>
    </div>
</x-app-layout>
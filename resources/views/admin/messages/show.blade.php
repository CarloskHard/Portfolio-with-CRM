<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detalle del Mensaje') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            <!-- TARJETA DEL MENSAJE -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-start mb-6 border-b pb-4">
                        <div>
                            <h3 class="text-2xl font-bold">{{ $message->subject }}</h3>
                            <p class="text-sm text-gray-500 mt-1">
                                Enviado: {{ $message->created_at->format('d/m/Y H:i') }} 
                                ({{ $message->created_at->diffForHumans() }})
                            </p>
                        </div>
                        <span class="{{ $message->contact_id ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }} px-3 py-1 rounded-full text-xs font-bold uppercase">
                            {{ $message->contact_id ? 'Asignado' : 'Pendiente' }}
                        </span>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-6 bg-gray-50 p-4 rounded">
                        <div>
                            <p class="text-xs font-bold text-gray-500 uppercase">Remitente</p>
                            <p class="text-lg">{{ $message->sender_name }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-gray-500 uppercase">Email</p>
                            <a href="mailto:{{ $message->sender_email }}" class="text-lg text-indigo-600 hover:underline">
                                {{ $message->sender_email }}
                            </a>
                        </div>
                    </div>

                    <div class="prose max-w-none">
                        <p class="whitespace-pre-wrap text-gray-700">{{ $message->content }}</p>
                    </div>
                </div>
            </div>

            <!-- ZONA DE ACCIONES / ASIGNACIÓN -->
            <!-- ZONA DE ACCIONES / ASIGNACIÓN -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg" x-data="{ editing: {{ $message->contact_id ? 'false' : 'true' }} }">
                <div class="p-6">
                    
                    <!-- BLOQUE 1: INFORMACIÓN ACTUAL (Si está asignado) -->
                    @if($message->contact_id)
                        <div x-show="!editing" class="flex flex-col sm:flex-row items-start sm:items-center gap-4 text-green-700 bg-green-50 p-4 rounded-lg border border-green-200 transition-all">
                            <svg class="w-8 h-8 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <div class="flex-1">
                                <p class="font-bold text-lg">Asignado correctamente</p>
                                <p class="text-sm">Cliente: <strong>{{ $message->contact->client->commercial_name }}</strong></p>
                                <p class="text-sm">Contacto: {{ $message->contact->first_name }} {{ $message->contact->last_name }}</p>
                            </div>
                            
                            <div class="flex flex-col gap-2">
                                <a href="{{ route('clients.edit', $message->contact->client) }}" class="px-3 py-1 bg-white border border-green-300 rounded text-sm hover:bg-green-100 text-center">
                                    Ver Ficha Cliente
                                </a>
                                <!-- BOTÓN PARA CAMBIAR -->
                                <button @click="editing = true" class="px-3 py-1 bg-green-600 text-white rounded text-sm hover:bg-green-700 text-center">
                                    Cambiar Cliente
                                </button>
                            </div>
                        </div>
                    @endif

                    <!-- BLOQUE 2: FORMULARIO DE ASIGNACIÓN (Oculto si ya está asignado, salvo que demos a editar) -->
                    <div x-show="editing" class="mt-4" style="display: none;">
                        <h3 class="text-lg font-bold mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            {{ $message->contact_id ? 'Reasignar a otro Cliente' : 'Asignar a Cliente' }}
                        </h3>
                        
                        <p class="text-sm text-gray-500 mb-4">
                            Selecciona la empresa o particular a quien pertenece este mensaje. 
                            Se guardará automáticamente el email <strong>{{ $message->sender_email }}</strong> en su ficha.
                        </p>
                        
                        <form action="{{ route('messages.assign', $message) }}" method="POST" class="flex flex-col sm:flex-row gap-4 items-end bg-gray-50 p-4 rounded-lg border border-gray-200">
                            @csrf
                            @method('PUT')
                            
                            <div class="w-full sm:flex-1">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Buscar Cliente</label>
                                <select name="client_id" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">-- Selecciona --</option>
                                    @foreach(\App\Models\Client::orderBy('commercial_name')->get() as $client)
                                        <option value="{{ $client->id }}" {{ $message->contact && $message->contact->client_id == $client->id ? 'selected' : '' }}>
                                            {{ $client->commercial_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="flex gap-2 w-full sm:w-auto">
                                <!-- Botón Cancelar (solo si ya estaba asignado) -->
                                @if($message->contact_id)
                                    <button type="button" @click="editing = false" class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300 font-medium">
                                        Cancelar
                                    </button>
                                @endif

                                <button type="submit" class="flex-1 sm:flex-none bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-6 rounded shadow">
                                    Guardar
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- BOTÓN BORRAR MENSAJE -->
                    <div class="mt-8 pt-6 border-t flex justify-between items-center">
                        <a href="{{ route('messages.index') }}" class="text-gray-500 hover:text-gray-700 font-medium flex items-center gap-1">
                            ← Volver a la bandeja
                        </a>
                        
                        <form action="{{ route('messages.destroy', $message) }}" method="POST">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-700 text-sm font-bold px-3 py-1 rounded hover:bg-red-50 transition" onclick="return confirm('¿Enviar este mensaje a la papelera?')">
                                Eliminar Mensaje
                            </button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
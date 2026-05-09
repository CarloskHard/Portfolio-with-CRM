<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Bandeja de Entrada') }}
            </h2>
            
            <!-- CONTADOR DE NO LEÍDOS -->
            @php $unreadCount = \App\Models\Message::where('is_read', false)->count(); @endphp
            @if($unreadCount > 0)
                <span class="bg-red-100 text-red-800 text-xs font-bold px-3 py-1 rounded-full">
                    {{ $unreadCount }} pendientes
                </span>
            @endif
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- BARRA DE HERRAMIENTAS (Filtros) -->
            <div class="bg-white p-4 rounded-lg shadow-sm mb-6 flex flex-col sm:flex-row justify-between items-center gap-4">
                <div class="flex items-center gap-2 w-full sm:w-auto flex-wrap">
                    <span class="text-sm text-gray-600 font-medium mr-1">Filtros:</span>

                    <a href="{{ request('status') === 'unread' ? route('messages.index', request()->except('status', 'page')) : request()->fullUrlWithQuery(['status' => 'unread', 'page' => 1]) }}"
                       class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-semibold border transition {{ request('status') === 'unread' ? 'bg-indigo-600 text-white border-indigo-600' : 'bg-indigo-50 text-indigo-700 border-indigo-200 hover:bg-indigo-100' }}">
                        No leídos
                    </a>

                    <a href="{{ request('status') === 'read' ? route('messages.index', request()->except('status', 'page')) : request()->fullUrlWithQuery(['status' => 'read', 'page' => 1]) }}"
                       class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-semibold border transition {{ request('status') === 'read' ? 'bg-gray-700 text-white border-gray-700' : 'bg-gray-100 text-gray-700 border-gray-300 hover:bg-gray-200' }}">
                        Leídos
                    </a>

                    <a href="{{ request('status') === 'trash' ? route('messages.index', request()->except('status', 'page')) : request()->fullUrlWithQuery(['status' => 'trash', 'page' => 1]) }}"
                       class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-semibold border transition {{ request('status') === 'trash' ? 'bg-red-600 text-white border-red-600' : 'bg-red-50 text-red-700 border-red-200 hover:bg-red-100' }}">
                        Papelera
                    </a>
                </div>

                @if(request('status') || request('sort'))
                    <a href="{{ route('messages.index') }}" class="text-sm text-indigo-600 hover:text-indigo-900 underline">
                        Limpiar filtros
                    </a>
                @endif
            </div>

            <!-- TABLA DE MENSAJES -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Estado
                                </th>

                                <!-- CABECERA: REMITENTE -->
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <a href="{{ request()->fullUrlWithQuery(['sort' => 'sender_name', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc']) }}" class="group flex items-center gap-1">
                                        Remitente
                                        @if(request('sort') == 'sender_name')
                                            <span class="text-indigo-600">{{ request('direction') == 'asc' ? '↑' : '↓' }}</span>
                                        @endif
                                    </a>
                                </th>

                                <!-- CABECERA: ASUNTO -->
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <a href="{{ request()->fullUrlWithQuery(['sort' => 'subject', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc']) }}" class="group flex items-center gap-1">
                                        Asunto
                                        @if(request('sort') == 'subject')
                                            <span class="text-indigo-600">{{ request('direction') == 'asc' ? '↑' : '↓' }}</span>
                                        @endif
                                    </a>
                                </th>

                                <!-- CABECERA: FECHA (Por defecto) -->
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <a href="{{ request()->fullUrlWithQuery(['sort' => 'created_at', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc']) }}" class="group flex items-center gap-1">
                                        Fecha
                                        @if(request('sort') == 'created_at' || !request('sort'))
                                            <span class="text-indigo-600">{{ request('direction') == 'asc' ? '↑' : '↓' }}</span>
                                        @endif
                                    </a>
                                </th>

                                <th class="px-6 py-3 text-right">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($messages as $message)
                                <tr class="hover:bg-gray-50 transition {{ !$message->is_read ? 'bg-indigo-50/50' : '' }}">
                                    <!-- Estado -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if(!$message->is_read)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                                                Nuevo
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                Leído
                                            </span>
                                        @endif
                                    </td>

                                    <!-- Remitente -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $message->sender_name }}</div>
                                        @if($message->contact)
                                            <div class="text-xs text-gray-500 flex items-center gap-1">
                                                <svg class="w-3 h-3 text-green-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                                {{ $message->contact->client->commercial_name }}
                                            </div>
                                        @else
                                            <div class="text-xs text-yellow-600">Desconocido</div>
                                        @endif
                                    </td>

                                    <!-- Asunto -->
                                    <td class="px-6 py-4">
                                        @if(request('status') === 'trash')
                                            <span class="text-sm text-gray-900 font-medium block truncate max-w-xs">{{ $message->subject }}</span>
                                        @else
                                            <a href="{{ route('messages.show', $message) }}" class="text-sm text-gray-900 hover:text-indigo-600 font-medium block truncate max-w-xs">
                                                {{ $message->subject }}
                                            </a>
                                        @endif
                                        <p class="text-xs text-gray-500 truncate max-w-xs">{{ $message->content }}</p>
                                    </td>

                                    <!-- Fecha -->
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $message->created_at->format('d/m/Y H:i') }}
                                        <div class="text-xs">{{ $message->created_at->diffForHumans() }}</div>
                                    </td>

                                    <!-- Acciones -->
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex items-center justify-end gap-3">
                                            @if(request('status') !== 'trash')
                                                <a href="{{ route('messages.show', $message) }}" class="text-indigo-600 hover:text-indigo-900" title="Leer">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                                </a>
                                            @endif
                                            
                                            <form action="{{ route('messages.destroy', $message) }}" method="POST" class="inline">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="text-gray-400 hover:text-red-600 transition" onclick="return confirm('{{ request('status') === 'trash' ? '¿Eliminar definitivamente este mensaje?' : '¿Enviar mensaje a la papelera?' }}')" title="{{ request('status') === 'trash' ? 'Eliminar definitivamente' : 'Enviar a papelera' }}">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                                        <div class="flex flex-col items-center justify-center">
                                            <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                                            <p>No hay mensajes con estos filtros.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <!-- Paginación -->
                <div class="p-4 border-t border-gray-200">
                    {{ $messages->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
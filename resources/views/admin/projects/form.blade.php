<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $project->exists ? __('Editar Proyecto') : __('Crear Nuevo Proyecto') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <form action="{{ $project->exists ? route('projects.update', $project) : route('projects.store') }}" 
                          method="POST" 
                          enctype="multipart/form-data" 
                          class="space-y-8">
                        
                        @csrf
                        @if ($errors->any())
                            <div class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
                                <strong>¡Hay errores en el formulario!</strong>
                                <ul class="mt-2 list-disc list-inside text-sm">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        
                        @if($project->exists)
                            @method('PUT')
                        @endif

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <!-- Título y Descripción -->
                            <div class="col-span-2 space-y-6">
                                <div>
                                    <label for="title" class="block text-sm font-bold text-gray-700">Título del Proyecto</label>
                                    <input type="text" name="title" id="title" value="{{ old('title', $project->title) }}" required
                                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>

                                <div>
                                    <label for="description" class="block text-sm font-bold text-gray-700">Descripción</label>
                                    <textarea name="description" id="description" rows="4" required
                                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('description', $project->description) }}</textarea>
                                </div>
                            </div>

                            <!-- URLs -->
                            <div>
                                <label for="url_repo" class="block text-sm font-bold text-gray-700">URL Repositorio (GitHub)</label>
                                <input type="url" name="url_repo" value="{{ old('url_repo', $project->url_repo) }}"
                                    class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>

                            <div>
                                <label for="url_demo" class="block text-sm font-bold text-gray-700">URL Demo (Web)</label>
                                <input type="url" name="url_demo" value="{{ old('url_demo', $project->url_demo) }}"
                                    class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                            
                            <!-- Visibilidad -->
                            <div>
                                <label for="visibility" class="block text-sm font-bold text-gray-700">Visibilidad</label>
                                <select name="visibility" id="visibility"
                                    class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="public" {{ old('visibility', $project->visibility) == 'public' ? 'selected' : '' }}>Público</option>
                                    <option value="private" {{ old('visibility', $project->visibility) == 'private' ? 'selected' : '' }}>Privado</option>
                                    <option value="draft" {{ old('visibility', $project->visibility) == 'draft' ? 'selected' : '' }}>Borrador</option>
                                </select>
                            </div>
                        </div>

                        <!-- SECCIÓN: IMÁGENES (DRAG & DROP) -->
                        <div class="col-span-2 pt-6 border-t border-gray-100" 
                             x-data="imageUploader({{ json_encode($project->images ??[]) }})">
                            <label class="block text-sm font-bold text-gray-700 mb-2">Galería de Imágenes</label>
                            <p class="text-xs text-gray-500 mb-4">Sube imágenes y arrástralas para cambiar el orden de aparición. La primera será la portada.</p>
                            
                            <!-- Hidden Inputs para procesar en el Backend -->
                            <input type="file" name="images[]" id="real_file_input" multiple class="hidden" accept="image/*">
                            
                            <template x-for="(item, index) in items" :key="index">
                                <input type="hidden" name="order[]" :value="getOrderValue(item)">
                            </template>

                            <!-- Botón "Añadir Archivos" -->
                            <div class="mb-4">
                                <button type="button" @click="$refs.fileInput.click()" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                    Añadir Imágenes
                                </button>
                                <input type="file" x-ref="fileInput" @change="addFiles" multiple accept="image/*" class="hidden">
                            </div>

                            <!-- Grid de Previsualización y Drag&Drop -->
                            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
                                <!-- Fíjate en el :key="item.id" -->
                                <template x-for="(item, index) in items" :key="item.id">
                                    <div class="relative aspect-video rounded-lg overflow-hidden border-2 border-transparent hover:border-indigo-500 transition-colors shadow-sm cursor-move bg-gray-100 flex items-center justify-center group"
                                        draggable="true"
                                        @dragstart="dragstart($event, index)"
                                        @dragover.prevent="dragover($event, index)"
                                        @drop.prevent="drop($event, index)"
                                        @dragend="dragend($event)"
                                        :class="{'opacity-50 border-dashed border-gray-400': draggedIndex === index}">
                                        
                                        <!-- Aquí usamos el URL del blob o la ruta del server -->
                                        <img :src="item.type === 'old' ? '/' + item.url : item.url" class="w-full h-full object-cover pointer-events-none">
                                        
                                        <!-- Insignia de Portada -->
                                        <div x-show="index === 0" class="absolute top-2 left-2 bg-indigo-600 text-white text-[10px] font-bold px-2 py-1 rounded shadow pointer-events-none">
                                            PORTADA
                                        </div>

                                        <!-- Botón Eliminar -->
                                        <button type="button" @click.stop="removeItem(index)" class="absolute top-2 right-2 bg-red-600/90 hover:bg-red-700 text-white p-1.5 rounded-full opacity-0 group-hover:opacity-100 transition-opacity transform hover:scale-110">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                        </button>
                                    </div>
                                </template>
                            </div>
                        </div>

                        <!-- SECCIÓN: TECNOLOGÍAS (Buscador Reactivo) -->
                        <div class="pt-6 border-t border-gray-100" 
                             x-data="techManager(
                                 {{ $technologies->map(fn($t) => ['id' => $t->id, 'name' => $t->name])->toJson() }},
                                 {{ $project->technologies->map(fn($t) =>['id' => $t->id, 'name' => $t->name])->toJson() }}
                             )">
                             
                            <label class="block text-sm font-bold text-gray-700 mb-2">Tecnologías Utilizadas</label>
                            
                            <!-- Hidden inputs para enviar al servidor -->
                            <template x-for="tech in selected" :key="tech.id">
                                <input type="hidden" name="technologies[]" :value="tech.id">
                            </template>

                            <div class="relative">
                                <!-- Input Buscador -->
                                <input type="text" 
                                    x-model="search" 
                                    @focus="isOpen = true" 
                                    @click.away="isOpen = false" 
                                    @keydown.enter.prevent="addFirstMatch()" 
                                    placeholder="Buscar tecnología (ej: Laravel, React...)"
                                    class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                
                                <!-- Dropdown de sugerencias -->
                                <ul x-show="isOpen && search.length > 0" class="absolute z-10 mt-1 w-full bg-white shadow-lg max-h-48 rounded-md py-1 text-base ring-1 ring-black ring-opacity-5 overflow-auto focus:outline-none sm:text-sm">
                                    
                                    <template x-for="tech in filteredTechs" :key="tech.id">
                                        <li @click="addTech(tech)" class="text-gray-900 cursor-pointer select-none relative py-2 pl-3 pr-9 hover:bg-indigo-600 hover:text-white transition-colors">
                                            <span x-text="tech.name" class="font-normal block truncate"></span>
                                        </li>
                                    </template>
                                    
                                    <li x-show="filteredTechs.length === 0" class="text-gray-500 cursor-default select-none relative py-2 pl-3 pr-9">
                                        No se encontraron resultados.
                                    </li>
                                </ul>
                            </div>

                            <!-- Etiquetas Seleccionadas -->
                            <div class="mt-4 flex flex-wrap gap-2">
                                <template x-for="tech in selected" :key="tech.id">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-indigo-100 text-indigo-800 border border-indigo-200 shadow-sm">
                                        <span x-text="tech.name"></span>
                                        <button type="button" @click="removeTech(tech.id)" class="ml-1.5 inline-flex items-center justify-center w-4 h-4 rounded-full text-indigo-400 hover:bg-indigo-200 hover:text-indigo-600 focus:outline-none transition-colors">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                        </button>
                                    </span>
                                </template>
                            </div>
                        </div>

                        <!-- Clientes -->
                        <div class="pt-6 border-t border-gray-100">
                            <label class="block text-sm font-bold text-gray-700 mb-3">Cliente Asociado (Opcional)</label>
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 max-h-48 overflow-y-auto p-4 bg-gray-50 rounded-lg border border-gray-200">
                                @foreach($clients as $client)
                                    <div class="flex items-center">
                                        <input type="checkbox" name="clients[]" value="{{ $client->id }}" id="client_{{ $client->id }}"
                                            @if((is_array(old('clients')) && in_array($client->id, old('clients'))) || ($project->clients->contains($client->id))) checked @endif
                                            class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                        <label for="client_{{ $client->id }}" class="ml-2 block text-sm text-gray-900 cursor-pointer">
                                            {{ $client->commercial_name }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Botones Submit -->
                        <div class="flex justify-end gap-4 pt-6 border-t border-gray-200">
                            <a href="{{ route('projects.index') }}" class="px-6 py-2.5 rounded-lg font-medium text-gray-700 hover:bg-gray-100 hover:text-gray-900 transition-colors border border-gray-300 shadow-sm">Cancelar</a>
                            <button type="submit" class="px-6 py-2.5 rounded-lg font-medium text-white bg-indigo-600 hover:bg-indigo-700 transition-colors shadow-md hover:shadow-lg">
                                {{ $project->exists ? 'Actualizar Proyecto' : 'Crear Proyecto' }}
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <!-- Scripts de AlpineJS -->
    <script>
        document.addEventListener('alpine:init', () => {

            // 1. GESTOR DE IMÁGENES
            Alpine.data('imageUploader', (existingImages) => ({
                items: [],         
                newFiles:[],      
                draggedIndex: null,

                init() {
                    if (existingImages && Array.isArray(existingImages)) {
                        existingImages.forEach((url, index) => {
                            this.items.push({
                                id: 'old_' + index + '_' + Date.now(), // ID único
                                type: 'old',
                                url: url, 
                                value: url 
                            });
                        });
                    }
                },

                addFiles(event) {
                    const files = Array.from(event.target.files);
                    
                    files.forEach(file => {
                        const originalIndex = this.newFiles.length;
                        this.newFiles.push(file);

                        // Solo guardamos datos simples en 'items' para no romper la reactividad de Alpine
                        this.items.push({
                            id: 'new_' + originalIndex + '_' + Date.now(), // ID único esencial para el HTML
                            type: 'new',
                            url: URL.createObjectURL(file), // Genera el Blob para ver la foto
                            originalIndex: originalIndex
                        });
                    });

                    this.updateFileInput();
                    event.target.value = ''; 
                },

                removeItem(index) {
                    this.items.splice(index, 1);
                },

                updateFileInput() {
                    const dataTransfer = new DataTransfer();
                    this.newFiles.forEach(file => {
                        dataTransfer.items.add(file);
                    });
                    document.getElementById('real_file_input').files = dataTransfer.files;
                },

                dragstart(event, index) {
                    this.draggedIndex = index;
                    event.dataTransfer.effectAllowed = 'move';
                },
                dragover(event, index) {
                    event.preventDefault(); 
                },
                drop(event, index) {
                    event.preventDefault();
                    if (this.draggedIndex === null || this.draggedIndex === index) return;

                    const item = this.items.splice(this.draggedIndex, 1)[0];
                    this.items.splice(index, 0, item);
                    this.draggedIndex = null;
                },
                dragend(event) {
                    this.draggedIndex = null;
                },
                
                getOrderValue(item) {
                    if (item.type === 'old') {
                        return 'old:' + item.url;
                    } else {
                        return 'new:' + item.originalIndex;
                    }
                }
            }));

            // 2. GESTOR DE TECNOLOGÍAS
            Alpine.data('techManager', (allTechs, initialSelected) => ({
                search: '',
                isOpen: false,
                source: allTechs,      
                selected: initialSelected ||[], 

                get filteredTechs() {
                    if (this.search === '') return[];
                    return this.source.filter(tech => {
                        const matchesSearch = tech.name.toLowerCase().includes(this.search.toLowerCase());
                        const notSelected = !this.selected.find(s => s.id === tech.id);
                        return matchesSearch && notSelected;
                    });
                },

                addTech(tech) {
                    this.selected.push(tech);
                    this.search = '';   
                    this.isOpen = false; 
                },

                removeTech(idToRemove) {
                    this.selected = this.selected.filter(tech => tech.id !== idToRemove);
                },

                // NUEVA FUNCIÓN: Al dar Enter
                addFirstMatch() {
                    if (this.filteredTechs.length > 0) {
                        this.addTech(this.filteredTechs[0]);
                    } else {
                        this.search = ''; // Opcional: limpiar si no hay coincidencias
                    }
                }
            }));
        });
    </script>
</x-app-layout>
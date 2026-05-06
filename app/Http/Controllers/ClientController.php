<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\QuoteVersion;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ClientController extends Controller
{
    /*
     * Listado de clientes.
     */
    public function index(Request $request)
    {
        // 1. Base de la consulta con el conteo de proyectos
        $query = Client::withCount('projects');

        // 2. FILTRO: Si hay un tipo en la URL (?type=company), filtramos
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // 3. ORDENACIÓN MEJORADA
        $sort = $request->input('sort');
        $direction = $request->input('direction', 'asc'); // Por defecto A-Z

        if ($sort === 'projects_count') {
            $query->orderBy('projects_count', $direction);
        } elseif ($sort === 'commercial_name') {
            // Ordenar alfabéticamente
            $query->orderBy('commercial_name', $direction);
        } else {
            // Orden por defecto (si no hay nada en la URL): los más nuevos primero
            $query->latest();
        }

        // 4. Paginación (Mantenemos los filtros en los enlaces de página 1, 2, 3...)
        $clients = $query->paginate(10)->withQueryString();

        return view('admin.clients.index', compact('clients'));
    }

    /**
     * Muestra el formulario de CREACIÓN.
     */
    public function create()
    {
        // PATRÓN MODELO VACÍO:
        // Pasamos un objeto vacío para que la vista 'form' pueda usar $client->commercial_name sin error
        $client = new Client();
        
        return view('admin.clients.form', compact('client'));
    }

    /**
     * Guarda el nuevo cliente en BBDD.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'commercial_name' => 'required|string|max:255',
            'type' => 'required|in:company,individual',
            'tax_id' => 'nullable|string|max:20', // CIF/NIF
            'notes' => 'nullable|string',
        ]);

        Client::create($validated);

        return redirect()->route('clients.index')->with('success', 'Cliente registrado correctamente.');
    }

    /**
     * Muestra el formulario de EDICIÓN.
     */
    public function edit(Client $client)
    {
        $client->load('quoteVersions');

        // Pasamos el cliente existente a la misma vista 'form'
        return view('admin.clients.form', compact('client'));
    }

    /**
     * Actualiza el cliente en BBDD.
     */
    public function update(Request $request, Client $client)
    {
        $validated = $request->validate([
            'commercial_name' => 'required|string|max:255',
            'type' => 'required|in:company,individual',
            'tax_id' => 'nullable|string|max:20',
            'notes' => 'nullable|string',
        ]);

        $client->update($validated);

        return redirect()->route('clients.index')->with('success', 'Cliente actualizado correctamente.');
    }

    /**
     * Elimina el cliente.
     */
    public function destroy(Client $client)
    {
        // Al borrar el cliente, se borrarán las relaciones en la tabla pivote
        // gracias al 'onDelete cascade' de la migración, pero NO los proyectos.
        $client->delete();

        return redirect()->route('clients.index')->with('success', 'Cliente eliminado.');
    }

    public function storeQuote(Request $request, Client $client)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'currency' => 'required|string|size:3',
            'quote_date' => 'nullable|date',
            'slug' => ['nullable', 'string', 'max:120', 'regex:/^[A-Za-z0-9\-_]+$/', Rule::unique('quote_versions', 'slug')],
            'items' => 'required|array|min:1',
            'items.*.name' => 'required|string|max:255',
            'items.*.description' => 'nullable|string|max:2000',
            'items.*.price' => 'required|numeric|min:0',
            'notes_text' => 'nullable|string',
        ]);

        $items = collect($validated['items'])
            ->map(function (array $item) {
                return [
                    'name' => trim((string) $item['name']),
                    'description' => trim((string) ($item['description'] ?? '')),
                    'price' => (float) $item['price'],
                ];
            })
            ->values()
            ->all();

        $notes = collect(explode("\n", (string) ($validated['notes_text'] ?? '')))
            ->map(fn ($line) => trim($line))
            ->filter()
            ->values()
            ->all();

        $baseSlug = $validated['slug'] ?: Str::slug($client->commercial_name.'-'.Str::limit($validated['title'], 40, ''), '-');
        $slug = $this->generateUniqueSlug($baseSlug);

        QuoteVersion::create([
            'client_id' => $client->id,
            'slug' => $slug,
            'title' => $validated['title'],
            'currency' => strtoupper($validated['currency']),
            'quote_date' => $validated['quote_date'] ?? now()->toDateString(),
            'items' => $items,
            'notes' => $notes,
        ]);

        return redirect()->route('clients.edit', $client)->with('success', 'Presupuesto generado y asociado al cliente.');
    }

    public function destroyQuote(Client $client, QuoteVersion $quoteVersion)
    {
        if ($quoteVersion->client_id !== $client->id) {
            abort(404);
        }

        $quoteVersion->delete();

        return redirect()->route('clients.edit', $client)->with('success', 'Presupuesto eliminado.');
    }

    private function generateUniqueSlug(string $baseSlug): string
    {
        $slug = Str::lower(trim($baseSlug, '-'));
        if ($slug === '') {
            $slug = 'presupuesto';
        }

        $candidate = $slug;
        $counter = 2;
        while (QuoteVersion::where('slug', $candidate)->exists()) {
            $candidate = $slug.'-'.$counter;
            $counter++;
        }

        return $candidate;
    }
}
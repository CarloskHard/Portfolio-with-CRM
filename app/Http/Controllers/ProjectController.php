<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Technology;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        $query = Project::with(['technologies', 'clients'])->latest();

        if ($request->filled('visibility')) {
            $query->where('visibility', $request->visibility);
        }

        if ($request->filled('client_id')) {
            $query->whereHas('clients', function ($q) use ($request) {
                $q->where('clients.id', $request->client_id);
            });
        }

        $projects = $query->paginate(10)->withQueryString();
        $clients = Client::orderBy('commercial_name')->get();

        return view('admin.projects.index', compact('projects', 'clients'));
    }

    public function create()
    {
        $project = new Project(); 
        $technologies = Technology::orderBy('name')->get();
        $clients = Client::orderBy('commercial_name')->get();
        
        return view('admin.projects.form', compact('project', 'technologies', 'clients'));
    }

    public function edit(Project $project)
    {
        $technologies = Technology::orderBy('name')->get();
        $clients = Client::orderBy('commercial_name')->get();

        return view('admin.projects.form', compact('project', 'technologies', 'clients'));
    }

    public function update(Request $request, Project $project)
    {
        $data = $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'order' => 'nullable|array', // Array que nos manda el Front con el orden
            'url_repo' => 'nullable|url',
            'url_demo' => 'nullable|url',
            'visibility' => 'required|in:public,private,draft',
            'technologies' => 'nullable|array',
            'technologies.*' => 'exists:technologies,id',
            'clients' => 'nullable|array',
            'clients.*' => 'exists:clients,id',
        ]);

        // GESTIÓN DE IMÁGENES Y SU ORDEN
        $finalImages = [];
        $newFiles = $request->file('images') ??[];
        $order = $request->input('order', []);
        $oldImages = $project->images ??[];

        foreach ($order as $item) {
            if (str_starts_with($item, 'old:')) {
                // Es una imagen que ya existía, la mantenemos en esta posición
                $finalImages[] = substr($item, 4); 
            } elseif (str_starts_with($item, 'new:')) {
                // Es una imagen nueva, sacamos su índice y la subimos
                $index = (int) substr($item, 4);
                if (isset($newFiles[$index])) {
                    $path = $newFiles[$index]->store('projects', 'public');
                    $finalImages[] = 'storage/' . $path;
                }
            }
        }

        // Borrar del disco las imágenes antiguas que el usuario ha quitado
        $imagesToDelete = array_diff($oldImages, $finalImages);
        foreach ($imagesToDelete as $img) {
            Storage::disk('public')->delete(str_replace('storage/', '', $img));
        }

        $data['images'] = $finalImages;

        // GUARDAR TODO
        $project->update($data);

        // Sincronizar relaciones
        $project->technologies()->sync($request->technologies ??[]);
        $project->clients()->sync($request->clients ??[]);

        return redirect()->route('projects.index')->with('success', 'Proyecto actualizado correctamente.');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'order' => 'nullable|array',
            'url_repo' => 'nullable|url',
            'url_demo' => 'nullable|url',
            'visibility' => 'required|in:public,private,draft',
            'technologies' => 'nullable|array', 
            'technologies.*' => 'exists:technologies,id',
            'clients' => 'nullable|array',
            'clients.*' => 'exists:clients,id',
        ]);

        // GESTIÓN DE IMÁGENES NUEVAS Y ORDEN
        $finalImages = [];
        $newFiles = $request->file('images') ??[];
        $order = $request->input('order',[]);

        foreach ($order as $item) {
            if (str_starts_with($item, 'new:')) {
                $index = (int) substr($item, 4);
                if (isset($newFiles[$index])) {
                    $path = $newFiles[$index]->store('projects', 'public');
                    $finalImages[] = 'storage/' . $path;
                }
            }
        }
        
        $data['images'] = $finalImages;

        // Crear Proyecto
        $project = Project::create($data);

        // Sincronizar Relaciones
        $project->technologies()->sync($request->technologies ??[]);
        $project->clients()->sync($request->clients ??[]);

        return redirect()->route('projects.index')->with('success', 'Proyecto creado correctamente.');
    }

    public function destroy(Project $project)
    {
        // Borrar todas las imágenes del servidor
        $images = $project->images ??[];
        foreach ($images as $img) {
            Storage::disk('public')->delete(str_replace('storage/', '', $img));
        }

        $project->delete();

        return redirect()->route('projects.index')->with('success', 'Proyecto eliminado.');
    }
}
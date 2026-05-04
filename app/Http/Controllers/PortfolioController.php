<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Technology;

class PortfolioController extends Controller
{
    public function index()
    {
        // Portada: Pedimos al Modelo 3 proyectos para el "destacados"
            /* Usamos 'with' (Eager Loading) para traer las tecnologías de golpe
               y ahorrar consultas a la base de datos (mejor rendimiento).    */
        $projects = Project::with('technologies')
                    ->where('visibility', 'public') // Solo los públicos
                    ->latest() // Ordenados por el más nuevo
                    ->get();

        // Traemos todas las tecnologías para la sección de skills
        $technologies = Technology::all();

        // Devolvemos la vista (el HTML) pasándole los datos
        return view('public.home', compact('projects', 'technologies'));
    }

    // Método para la página de "Ver todos los proyectos"
    public function showAll()
    {
        // Aquí traemos todos, pero paginados de 9 en 9 para que cargue rápido
        $projects = Project::with('technologies')
                    ->where('visibility', 'public')
                    ->latest()
                    ->paginate(9); 

        return view('public.projects', compact('projects'));
    }

    //Método para la página de historia
    public function about()
    {
        return view('public.about');
    }

    public function cv()
    {
        return view('public.cv');
    }

    public function cvDownload()
    {
        return response()
            ->view('public.cv', ['downloadMode' => true], 200)
            ->header('Content-Type', 'text/html; charset=UTF-8')
            ->header('Content-Disposition', 'attachment; filename="carlos-burgos-tavora-cv.html"');
    }
}
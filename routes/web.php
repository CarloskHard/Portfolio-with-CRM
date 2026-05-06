<?php

/*
|--------------------------------------------------------------------------
| importación de todas las rutas de la web
|--------------------------------------------------------------------------
*/
use Illuminate\Support\Facades\Route;
//Rutas públicas
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ContactController;

//Rutas Privadas
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\MessageController;

/*
|--------------------------------------------------------------------------
| Rutas Web PÚBLICAS
|--------------------------------------------------------------------------
*/

// Portada
Route::get('/', [PortfolioController::class, 'index'])->name('home');

// Ruta para ver el catálogo completo
Route::get('/proyectos', [PortfolioController::class, 'showAll'])->name('public.projects');

// Para mensajes de contacto
Route::post('/contact', [ContactController::class, 'storePublicMessage'])->name('contact.store');

// Ruta para "Sobre mí / Historia"
Route::get('/sobre-mi',[PortfolioController::class, 'about'])->name('public.about');

// CV (solo por enlace directo, sin entrada en el menú público)
Route::get('/cv', [PortfolioController::class, 'cv'])->name('public.cv');
Route::get('/cv/descargar', [PortfolioController::class, 'cvDownload'])->name('public.cv.download');

// Presupuestos (solo por enlace directo, sin entrada en el menú público)
Route::get('/presupuesto/{slug?}', [PortfolioController::class, 'quote'])
    ->where('slug', '[A-Za-z0-9\-_]+')
    ->name('public.quote');

/*
|--------------------------------------------------------------------------
| Rutas Web PRIVADAS  (Backend / Admin)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified'])->group(function () {
    
    // Dashboard
    Route::get('/dashboard', function () {
        return view('admin.dashboard'); 
    })->name('dashboard');


    Route::patch('projects/reorder', [ProjectController::class, 'reorder'])->name('projects.reorder');

    // Esto crea automáticamente las rutas: projects.index, projects.create, projects.store...
    Route::resource('projects', ProjectController::class);


    // CRUD de Clientes
    Route::resource('clients', ClientController::class);
    Route::post('/clients/{client}/quotes', [ClientController::class, 'storeQuote'])->name('clients.quotes.store');
    Route::delete('/clients/{client}/quotes/{quoteVersion}', [ClientController::class, 'destroyQuote'])->name('clients.quotes.destroy');


    // GESTIÓN DE CONTACTOS (Agenda dentro de Clientes)
    // 1. Guardar nuevo contacto vinculado a un cliente
    Route::post('/clients/{client}/contacts', [ContactController::class, 'store'])->name('client.contacts.store');
    // 2. Actualizar un contacto existente
    Route::put('/contacts/{contact}', [ContactController::class, 'update'])->name('contacts.update');
    // 3. Borrar un contacto
    Route::delete('/contacts/{contact}', [ContactController::class, 'destroy'])->name('contacts.destroy');


    // CRUD de Mensajes
    Route::resource('messages', MessageController::class)->only(['index', 'show', 'destroy']);
    Route::put('/messages/{message}/assign', [MessageController::class, 'assign'])->name('messages.assign');

    // Perfil de Usuario
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Rutas de Autenticación (Login, Register, etc.)
require __DIR__.'/auth.php';
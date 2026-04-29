<?php

namespace App\Http\Controllers;

use App\Jobs\SendNewContactAlert;
use App\Models\Client;
use App\Models\Contact;
use App\Models\ContactMethod;
use App\Models\Message;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    // Guardar un nuevo contacto asociado a un cliente
    public function storeContact(Request $request, Client $client)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'position' => 'nullable|string|max:255',
            'email' => 'nullable|email',
            'phone' => 'nullable|string|max:20', // <--- Nuevo campo
            'notes' => 'nullable|string',         // <--- Nuevo campo
        ]);

        // 1. Crear el Contacto (Ahora con notas)
        $contact = $client->contacts()->create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'position' => $request->position,
            'notes' => $request->notes,
        ]);

        // 2. Guardar Email (si hay)
        if ($request->filled('email')) {
            $contact->contactMethods()->create([
                'type' => 'email',
                'value' => $request->email,
                'details' => 'Principal'
            ]);
        }

        // 3. Guardar Teléfono (si hay) - Nuevo
        if ($request->filled('phone')) {
            $contact->contactMethods()->create([
                'type' => 'phone',
                'value' => $request->phone,
                'details' => 'Móvil'
            ]);
        }

        return back()->with('success', 'Contacto añadido correctamente.');
    }
    

    // Borrar un contacto
    public function destroy(Contact $contact)
    {
        $contact->delete();
        return back()->with('success', 'Contacto eliminado.');
    }

     public function storePublicMessage(Request $request)
    {
        // 1. Validar (Laravel automáticamente devolverá JSON si la petición es AJAX)
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'content' => 'required|string|min:10',
        ],[
            'content.min' => 'El mensaje debe tener al menos 10 caracteres para poder ayudarte mejor.'
        ]);

        // 2. Crear el mensaje
        // No pasamos contact_id porque es un desconocido (null)
        $message = Message::create([
            'sender_name' => $validated['name'],
            'sender_email' => $validated['email'],
            'subject' => 'Nuevo mensaje web de ' . $validated['name'],
            'content' => $validated['content'],
            'is_read' => false,
        ]);

        $channels = config('services.contact_alerts.channels', []);
        if (is_array($channels) && ! empty($channels)) {
            SendNewContactAlert::dispatch($message);
        }

        // 3. Respuesta Profesional
        // Si la petición viene de nuestro script Fetch (AJAX):
        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => '¡Tu mensaje está en camino! Te contestaré lo antes posible.'
            ]);
        }

        // Fallback clásico (En vez de URL::previous(), forzamos a que vaya al ancla de forma limpia)
        return redirect('/#contact')->with('status', '¡Tu mensaje está en camino! Te contestaré lo antes posible.');
    }
}
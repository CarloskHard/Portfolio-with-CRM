<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->input('status');
        $query = Message::with('contact.client');

        if ($status === 'trash') {
            $query->onlyTrashed();
        }

        // 1. FILTRO: Estado (Leídos / No leídos / Papelera)
        if ($status === 'unread') {
            $query->where('is_read', false);
        } elseif ($status === 'read') {
            $query->where('is_read', true);
        }

        // 2. ORDENACIÓN
        $sort = $request->input('sort', 'created_at'); // Por defecto fecha
        $direction = $request->input('direction', 'desc'); // Por defecto nuevos primero

        // Permitimos ordenar por estas columnas
        if (in_array($sort, ['created_at', 'sender_name', 'subject', 'is_read'])) {
            $query->orderBy($sort, $direction);
        }

        $messages = $query->paginate(15)->withQueryString();
        
        return view('admin.messages.index', compact('messages', 'status'));
    }

    public function show(Message $message)
    {
        // Al abrirlo, lo marcamos como leído automáticamente
        if (!$message->is_read) {
            $message->update(['is_read' => true]);
        }
        
        return view('admin.messages.show', compact('message'));
    }

    public function destroy(string $message)
    {
        $message = Message::withTrashed()->findOrFail($message);

        if ($message->trashed()) {
            $message->forceDelete();
            return redirect()->route('messages.index', ['status' => 'trash'])->with('success', 'Mensaje eliminado definitivamente.');
        }

        $message->delete();
        return redirect()->route('messages.index')->with('success', 'Mensaje enviado a la papelera.');
    }

    // Método para asignar mensaje a un cliente existente
    public function assign(Request $request, Message $message)
    {
        $request->validate([
            'client_id' => 'required|exists:clients,id'
        ]);

        // 1. Buscamos o creamos el Contacto dentro del Cliente seleccionado
        $contact = \App\Models\Contact::firstOrCreate(
            [
                'client_id' => $request->client_id,
                'first_name' => $message->sender_name
            ],
            [
                'last_name' => '', // Apellido vacío por defecto
                'notes' => 'Creado automáticamente desde mensaje web'
            ]
        );

        // 2. Guardamos el Email
        if ($message->sender_email) {
            // Usamos firstOrCreate para no duplicar si ya tenía ese email guardado
            $contact->contactMethods()->firstOrCreate(
                [
                    'type' => 'email',
                    'value' => $message->sender_email
                ],
                [
                    'details' => 'Web'
                ]
            );
        }

        // 3. Vinculamos (o re-vinculamos) el mensaje
        $message->update([
            'contact_id' => $contact->id
        ]);

        return redirect()->back()->with('success', 'Cliente asignado y email guardado en la ficha.');
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = ['commercial_name', 'type', 'tax_id', 'notes', 'documentation_slug'];

    // Un cliente tiene muchos contactos (empleados)
    public function contacts()
    {
        return $this->hasMany(Contact::class);
    }

    // Un cliente puede estar asociado a varios proyectos
    public function projects()
    {
        return $this->belongsToMany(Project::class, 'project_client')
            ->orderBy('projects.sort_order')
            ->orderBy('projects.id');
    }

    // Relación: Un cliente tiene muchos mensajes a través de sus contactos
    public function messages()
    {
        return $this->hasManyThrough(Message::class, Contact::class);
    }

    // Un cliente puede tener múltiples versiones de presupuesto
    public function quoteVersions()
    {
        return $this->hasMany(QuoteVersion::class)->latest();
    }
}
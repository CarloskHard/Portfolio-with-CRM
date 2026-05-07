<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable =[
        'title', 'description', 'images', 'sort_order',
        'visibility', 'url_demo', 'url_repo', 'demo_cta_label'
    ];

    // Esto convierte automáticamente el JSON de la base de datos a un array de PHP y viceversa
    protected $casts =[
        'images' => 'array', 
    ];

    public function technologies()
    {
        return $this->belongsToMany(Technology::class);
    }

    public function clients()
    {
        return $this->belongsToMany(Client::class, 'project_client');
    }
}
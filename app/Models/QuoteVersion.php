<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuoteVersion extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'slug',
        'title',
        'currency',
        'items',
        'notes',
        'quote_date',
    ];

    protected $casts = [
        'items' => 'array',
        'notes' => 'array',
        'quote_date' => 'date',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Prunable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Message extends Model
{
    use HasFactory, SoftDeletes, Prunable;

    protected $fillable = [
        'contact_id', 
        'sender_name', 
        'sender_email', 
        'subject', 
        'content', 
        'is_read'
    ];

    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }

    public function prunable(): Builder
    {
        return static::onlyTrashed()
            ->where('deleted_at', '<=', now()->subMonth());
    }
}
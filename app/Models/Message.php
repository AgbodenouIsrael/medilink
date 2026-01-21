<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = ['chat_id', 'expediteur_type', 'expediteur_id', 'contenu', 'lu', 'date_envoi'];

    public function chat()
    {
        return $this->belongsTo(Chat::class);
    }

    // Polymorphic sender
    public function expediteur()
    {
        return $this->morphTo();
    }
}

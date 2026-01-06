<?php

// app/Models/Medecin.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Medecin extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'nom', 'prenom', 'email', 'password', 'contact',
        'specialite_id', 'numero_licence', 'certificat_path',
        'statut', 'zone_couverture'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
}
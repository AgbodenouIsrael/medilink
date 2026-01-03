<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Patient extends Authenticatable
{
    use Notifiable;

    protected $table = 'patients';
    protected $primaryKey = 'patient_id';

    protected $fillable = [
        'nom', 'prenom', 'date_naissance', 'genre',
        'contact', 'email', 'adresse', 'zone', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'date_naissance' => 'date',
        'password' => 'hashed', // Laravel gère le hachage tout seul
    ];
}
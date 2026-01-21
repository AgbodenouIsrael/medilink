<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Patient extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'nom',
        'prenom',
        'date_naissance',
        'genre',
        'contact',
        'email',
        'adresse',
        'zone_id',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'date_naissance' => 'date',
        'password' => 'hashed',
    ];

    // Nouvelles relations
    public function antecedents()
    {
        return $this->hasMany(Antecedent::class);
    }

    public function allergies()
    {
        return $this->hasMany(Allergie::class);
    }

    public function ordonnances()
    {
        return $this->hasMany(Ordonnance::class);
    }

    public function diagnostiques()
    {
        return $this->hasMany(Diagnostique::class);
    }

    public function traitements()
    {
        return $this->hasMany(Traitement::class);
    }

    public function documents()
    {
        return $this->hasMany(DocumentMedical::class);
    }

    public function autorisations()
    {
        return $this->hasMany(Autorisation::class);
    }
}
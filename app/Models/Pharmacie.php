<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Pharmacie extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'nom_officine',
        'pharmacien_titulaire',
        'numero_licence',
        'adresse_complete',
        'email',
        'telephone',
        'zone_id',
        'password',
        'latitude',
        'longitude',
        'accepte_ordonnances',
        'en_ligne',
        'horaires_ouverture',
        'statut',
        'fichier_licence_path'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'password' => 'hashed',
        'accepte_ordonnances' => 'boolean',
        'en_ligne' => 'boolean',
        'horaires_ouverture' => 'array',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
    ];

    public function zone()
    {
        return $this->belongsTo(Zone::class);
    }

    public function medicaments()
    {
        return $this->hasMany(Medicament::class);
    }
}

<?php

namespace App\Models;

// On importe la classe Authenticatable au lieu du Model classique
use Illuminate\Foundation\Auth\User as Authenticatable; 
use Illuminate\Notifications\Notifiable;

class Patient extends Authenticatable
{
    use Notifiable;

    protected $table = 'patients'; // On précise le nom de la table
    protected $primaryKey = 'patient_id'; // On précise ta clé primaire personnalisée

    /**
     * Les champs qui peuvent être remplis en masse.
     * ATTENTION : Ajoute bien 'zone' ici car il est dans ton contrôleur !
     */
    protected $fillable = [
        'nom',
        'prenom',
        'date_naissance',
        'genre',
        'contact',
        'email',
        'adresse',
        'zone',
        'mot_de_passe',
    ];

    /**
     * Laravel cherche par défaut une colonne 'password'. 
     * Comme la tienne s'appelle 'mot_de_passe', on lui dit ici :
     */
    public function getAuthPassword()
    {
        return $this->mot_de_passe;
    }

    /**
     * On cache le mot de passe lors des exports (JSON, etc.)
     */
    protected $hidden = [
        'mot_de_passe',
    ];
}
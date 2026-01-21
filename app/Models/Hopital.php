<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Hopital extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'nom',
        'email',
        'password',
        'contact',
        'adresse',
        'zone_id',
        'fichier_enregistrement_path',
        'statut'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'password' => 'hashed',
    ];

    public function zone()
    {
        return $this->belongsTo(Zone::class);
    }

    public function medecins()
    {
        return $this->belongsToMany(Medecin::class, 'hopital_medecins')
            ->withPivot('role', 'horaires', 'statut')
            ->withTimestamps();
    }

    public function autorisations()
    {
        return $this->hasMany(Autorisation::class);
    }

    // Patients linked via accepted authorizations for this hospital
    public function patients()
    {
        return $this->belongsToMany(Patient::class, 'autorisations')
            ->wherePivot('statut', 'approuve')
            ->withPivot('type_acces', 'date_fin', 'medecin_id');
    }
}

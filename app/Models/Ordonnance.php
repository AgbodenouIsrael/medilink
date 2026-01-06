<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ordonnance extends Model
{
    protected $fillable = [
        'patient_id', 'medecin_id', 'date_prescription',
        'numero_ordonnance', 'statut', 'instructions',
        'date_debut_traitement', 'date_fin_traitement'
    ];
    
    protected $casts = [
        'date_prescription' => 'date',
        'date_debut_traitement' => 'date',
        'date_fin_traitement' => 'date',
    ];
    
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
    
    public function medecin()
    {
        return $this->belongsTo(Medecin::class);
    }
    
    public function medicaments()
    {
        return $this->hasMany(OrdonnanceMedicament::class);
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Allergie extends Model
{
    protected $fillable = [
        'patient_id', 'nom_allergie', 'type', 
        'gravite', 'symptomes', 'traitement', 'date_decouverte'
    ];
    
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
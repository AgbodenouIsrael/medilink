<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Antecedent extends Model
{
    protected $fillable = [
        'patient_id', 'type', 'description', 
        'date_diagnostic', 'statut', 'commentaires'
    ];
    
    protected $casts = [
        'date_diagnostic' => 'date',
    ];
    
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
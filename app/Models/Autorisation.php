<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Autorisation extends Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;

    protected $fillable = [
        'patient_id',
        'medecin_id',
        'hopital_id',
        'type_acces',
        'statut',
        'date_debut',
        'date_fin',
        'motif',
        'created_by_id',
        'created_by_type'
    ];

    protected $casts = [
        'date_fin' => 'datetime',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function medecin()
    {
        return $this->belongsTo(Medecin::class);
    }

    public function hopital()
    {
        return $this->belongsTo(Hopital::class);
    }
}

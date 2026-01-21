<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DossierMedical extends Model
{
    protected $table = 'dossier_medicaux';

    protected $fillable = [
        'patient_id',
        'medecin_id',
        'antecedents',
        'allergies',
        'traitements_en_cours',
        'documents',
        'acces'
    ];

    protected $casts = [
        'documents' => 'array',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function medecin()
    {
        return $this->belongsTo(Medecin::class); // Médecin traitant principal
    }
}

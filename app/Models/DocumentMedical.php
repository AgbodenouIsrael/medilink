<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocumentMedical extends Model
{
    protected $table = 'documents_medicaux';

    protected $fillable = [
        'patient_id',
        'type_document',
        'titre',
        'date_document',
        'chemin_fichier',
        'description',
    ];

    protected $casts = [
        'date_document' => 'date',
    ];

    public function patient() // Relation avec le patient
    {
        return $this->belongsTo(Patient::class);
    }
}

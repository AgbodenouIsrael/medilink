<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medicament extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'dosage',
        'description',
        'pharmacie_id',
        'quantite',
        'seuil_alerte',
        'prix_unitaire',
        'date_expiration',
        'visible_public'
    ];

    protected $casts = [
        'date_expiration' => 'date',
        'visible_public' => 'boolean',
        'prix_unitaire' => 'decimal:2',
    ];

    public function pharmacie()
    {
        return $this->belongsTo(Pharmacie::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vente extends Model
{
    use HasFactory;

    protected $fillable = [
        'pharmacie_id',
        'patient_id',
        'total_montant',
        'mode_paiement',
        'date_vente'
    ];

    protected $casts = [
        'date_vente' => 'datetime',
        'total_montant' => 'decimal:2',
    ];

    public function pharmacie()
    {
        return $this->belongsTo(Pharmacie::class);
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function details()
    {
        return $this->hasMany(DetailVente::class);
    }
}

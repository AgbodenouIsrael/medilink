<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrdonnanceMedicament extends Model
{
    use HasFactory;

    protected $fillable = [
        'ordonnance_id',
        'nom_medicament',
        'dosage',
        'instructions',
        'quantite',
    ];

    public function ordonnance()
    {
        return $this->belongsTo(Ordonnance::class);
    }
}

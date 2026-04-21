<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    protected $fillable = ['type', 'statut', 'patient_id', 'medecin_id', 'pharmacie_id', 'hopital_id'];

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function medecin()
    {
        return $this->belongsTo(Medecin::class);
    }

    public function pharmacie()
    {
        return $this->belongsTo(Pharmacie::class);
    }

    public function hopital()
    {
        return $this->belongsTo(Hopital::class);
    }
}

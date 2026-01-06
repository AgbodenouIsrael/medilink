<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

    // Dans app/Models/DossierMedical.php
class DossierMedical extends Model
{
    protected $table = 'dossier_medicaux';
    
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
    
    public function medecin()
    {
        return $this->belongsTo(Medecin::class);
    }
}

// Dans app/Models/RendezVous.php
class RendezVous extends Model
{
    protected $table = 'rendez_vous';
    
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

// Dans app/Models/Message.php
class Message extends Model
{
    public function expediteur()
    {
        return $this->morphTo();
    }
    
    public function destinataire()
    {
        return $this->morphTo();
    }
    
    public function chat()
    {
        return $this->belongsTo(Chat::class);
    }
}


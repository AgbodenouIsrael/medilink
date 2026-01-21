<?php

namespace App\Http\Controllers;

use App\Models\Antecedent;
use App\Models\Allergie;
use App\Models\Ordonnance;
use App\Models\Diagnostique;
use App\Models\Traitement;
use App\Models\DocumentMedical;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DossierMedicalController extends Controller
{
   // Afficher le dossier médical complet
public function index()
{
    // Récupérer le patient connecté
    $patient = Auth::guard('patient')->user();
    
    // Vérifier si le patient est connecté
    if (!$patient) {
        return redirect()->route('connexion')->with('error', 'Veuillez vous connecter.');
    }
    
    // Récupérer toutes les données du patient
    $antecedents = $patient->antecedents ?? collect();
    $allergies = $patient->allergies ?? collect();
    $ordonnances = $patient->ordonnances()->orderBy('date_prescription', 'desc')->get() ?? collect();
    $documents = $patient->documents ?? collect();
    
    // Pour diagnostiques et traitements (si vous avez ces modèles)
    $diagnostiques = method_exists($patient, 'diagnostiques') ? $patient->diagnostiques : collect();
    $traitements = method_exists($patient, 'traitements') ? $patient->traitements : collect();
    
    return view('ma_fiche_medicale', compact(
        'patient', // N'oubliez pas d'envoyer $patient à la vue aussi
        'antecedents', 'allergies', 'ordonnances', 
        'diagnostiques', 'traitements', 'documents'
    ));
}
    
    // CRUD pour Antécédents
    public function storeAntecedent(Request $request)
    {
        $request->validate([
            'type' => 'required|in:familial,personnel,chirurgical,obstetrical,autres',
            'description' => 'required|string|max:1000',
            'date_diagnostic' => 'nullable|date',
            'statut' => 'required|in:actif,gueri,en_suivi',
            'commentaires' => 'nullable|string|max:500',
        ]);
        
        $antecedent = new Antecedent($request->all());
        $antecedent->patient_id = Auth::guard('patient')->id();
        $antecedent->save();
        
        return back()->with('success', 'Antécédent ajouté avec succès.');
    }
    
    public function updateAntecedent(Request $request, $id)
    {
        $antecedent = Antecedent::where('patient_id', Auth::guard('patient')->id())
            ->findOrFail($id);
        
        $request->validate([
            'type' => 'required|in:familial,personnel,chirurgical,obstetrical,autres',
            'description' => 'required|string|max:1000',
            'date_diagnostic' => 'nullable|date',
            'statut' => 'required|in:actif,gueri,en_suivi',
            'commentaires' => 'nullable|string|max:500',
        ]);
        
        $antecedent->update($request->all());
        
        return back()->with('success', 'Antécédent modifié avec succès.');
    }
    
    public function destroyAntecedent($id)
    {
        $antecedent = Antecedent::where('patient_id', Auth::guard('patient')->id())
            ->findOrFail($id);
        $antecedent->delete();
        
        return back()->with('success', 'Antécédent supprimé avec succès.');
    }
    
    // CRUD pour Allergies
    public function storeAllergie(Request $request)
    {
        $request->validate([
            'nom_allergie' => 'required|string|max:255',
            'type' => 'required|in:medicamenteuse,alimentaire,environnementale,autre',
            'gravite' => 'required|in:legere,moderee,grave,tres_grave',
            'symptomes' => 'nullable|string|max:1000',
            'traitement' => 'nullable|string|max:500',
            'date_decouverte' => 'nullable|date',
        ]);
        
        $allergie = new Allergie($request->all());
        $allergie->patient_id = Auth::guard('patient')->id();
        $allergie->save();
        
        return back()->with('success', 'Allergie ajoutée avec succès.');
    }
    
    public function destroyAllergie($id)
    {
        $allergie = Allergie::where('patient_id', Auth::guard('patient')->id())
            ->findOrFail($id);
        $allergie->delete();
        
        return back()->with('success', 'Allergie supprimée avec succès.');
    }
    
    // CRUD pour Documents
    public function storeDocument(Request $request)
    {
        $request->validate([
            'type_document' => 'required|in:ordonnance,resultat_analyse,radiologie,certificat,autre',
            'titre' => 'required|string|max:255',
            'date_document' => 'nullable|date',
            'fichier' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'description' => 'nullable|string|max:500',
        ]);
        
        if ($request->hasFile('fichier')) {
            $path = $request->file('fichier')->store('documents_medicaux', 'public');
            
            $document = new DocumentMedical();
            $document->patient_id = Auth::guard('patient')->id();
            $document->type_document = $request->type_document;
            $document->titre = $request->titre;
            $document->date_document = $request->date_document;
            $document->chemin_fichier = $path;
            $document->description = $request->description;
            $document->save();
            
            return back()->with('success', 'Document ajouté avec succès.');
        }
        
        return back()->with('error', 'Erreur lors du téléchargement du fichier.');
    }
    
    public function destroyDocument($id)
    {
        $document = DocumentMedical::where('patient_id', Auth::guard('patient')->id())
            ->findOrFail($id);
        
        Storage::disk('public')->delete($document->chemin_fichier);
        $document->delete();
        
        return back()->with('success', 'Document supprimé avec succès.');
    }
}
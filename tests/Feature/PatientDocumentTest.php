<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use App\Models\Patient;
use App\Models\Zone;

class PatientDocumentTest extends TestCase
{
    use RefreshDatabase;

    public function test_patient_can_upload_document()
    {
        Storage::fake('public');

        $zone = Zone::create(['nom' => 'Zone Test', 'ville' => 'Lome']);
        $patient = Patient::create([
            'nom' => 'Doe',
            'prenom' => 'John',
            'date_naissance' => '1990-01-01',
            'genre' => 'Homme',
            'contact' => '12345678',
            'email' => 'john@test.com',
            'password' => 'password',
            'zone_id' => $zone->id
        ]);

        $file = UploadedFile::fake()->create('document.pdf', 100);

        $response = $this->actingAs($patient, 'patient')
            ->post(route('document.store'), [
                'titre' => 'Test Document',
                'type_document' => 'ordonnance', // assuming this is a valid type
                'date_document' => now()->format('Y-m-d'),
                'fichier' => $file,
                'description' => 'Test description'
            ]);

        $response->assertSessionHas('success');

        // Assert database has record
        $this->assertDatabaseHas('documents_medicaux', [
            'titre' => 'Test Document',
            'patient_id' => $patient->id
        ]);

        // Assert file exists
        // The controller stores in 'documents_medicaux' folder within public disk
        // We need to check if any file exists in that directory
        // Since the filename is hashed, we check if the directory is not empty or retrieve the path from DB

        $document = \App\Models\DocumentMedical::where('titre', 'Test Document')->first();
        Storage::disk('public')->assertExists($document->chemin_fichier);
    }
}

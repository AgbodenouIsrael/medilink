<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Pharmacie;
use App\Models\Medicament;
use App\Models\Zone;
use App\Models\Ordonnance;
use App\Models\Patient;
use App\Models\Medecin;
use App\Models\Specialite; // Import Specialite
use Illuminate\Support\Facades\Hash;

class PharmacyFlowTest extends TestCase
{
    use RefreshDatabase;

    protected $pharmacie;

    protected function setUp(): void
    {
        parent::setUp();

        $zone = Zone::create(['nom' => 'Zone Test', 'ville' => 'Lome']);

        $this->pharmacie = Pharmacie::create([
            'nom_officine' => 'Pharmacie Test',
            'pharmacien_titulaire' => 'Dr Test',
            'numero_licence' => 'LIC-123',
            'adresse_complete' => 'Address Test',
            'email' => 'pharmacie@test.com',
            'telephone' => '90000000',
            'zone_id' => $zone->id,
            'password' => Hash::make('password'),
            'statut' => 'valide',
            'accepte_ordonnances' => true
        ]);
    }

    public function test_can_view_dashboard()
    {
        $response = $this->actingAs($this->pharmacie, 'pharmacie')
            ->get(route('dashboard_pharmacie'));

        $response->assertStatus(200);
    }

    public function test_can_process_sale()
    {
        $medicament = Medicament::create([
            'nom' => 'Doliprane',
            'dosage' => '500mg',
            'pharmacie_id' => $this->pharmacie->id,
            'quantite' => 10,
            'prix_unitaire' => 1000,
            'seuil_alerte' => 5
        ]);

        $response = $this->actingAs($this->pharmacie, 'pharmacie')
            ->postJson(route('pharmacie.process_sale'), [
                'total' => 2000,
                'items' => [
                    ['id' => $medicament->id, 'qty' => 2]
                ]
            ]);

        $response->assertStatus(200)
            ->assertJson(['success' => true]);

        $this->assertDatabaseHas('medicaments', [
            'id' => $medicament->id,
            'quantite' => 8 // 10 - 2
        ]);

        $this->assertDatabaseHas('ventes', [
            'pharmacie_id' => $this->pharmacie->id,
            'total_montant' => 2000
        ]);
    }

    public function test_can_serve_prescription()
    {
        // Create necessary dependencies for Medecin
        $specialite = Specialite::create(['nom' => 'Generaliste']); // Create generic specialite

        $medecin = Medecin::create([
            'nom' => 'Doctor',
            'prenom' => 'Who',
            'email' => 'doc@test.com',
            'password' => 'password',
            'contact' => '123',
            'numero_licence' => 'DOC123',
            'certificat_path' => 'path',
            'specialite_id' => $specialite->id // Assign specialite_id
        ]);

        $patient = Patient::create([
            'nom' => 'Doe',
            'prenom' => 'John',
            'date_naissance' => '1990-01-01',
            'genre' => 'Homme',
            'contact' => '12345678',
            'email' => 'john@test.com',
            'password' => 'password',
            'zone_id' => $this->pharmacie->zone_id // Same zone to be visible
        ]);

        $ordonnance = Ordonnance::create([
            'patient_id' => $patient->id,
            'medecin_id' => $medecin->id,
            'date_prescription' => now(),
            'numero_ordonnance' => 'ORD-TEST',
            'statut' => 'valide'
        ]);

        $response = $this->actingAs($this->pharmacie, 'pharmacie')
            ->postJson(route('pharmacie.prescription.serve', $ordonnance->id));

        $response->assertStatus(200)
            ->assertJson(['success' => true]);

        $this->assertDatabaseHas('ordonnances', [
            'id' => $ordonnance->id,
            'statut' => 'terminee'
        ]);
    }

    public function test_can_access_chat()
    {
        $response = $this->actingAs($this->pharmacie, 'pharmacie')
            ->get(route('pharmacie.messages'));

        $response->assertStatus(200);
    }

    public function test_can_update_profile()
    {
        $response = $this->actingAs($this->pharmacie, 'pharmacie')
            ->post(route('pharmacie.update_profil'), [
                'nom_officine' => 'New Name',
                'pharmacien_titulaire' => 'New Owner',
                'adresse_complete' => 'New Address',
                'telephone' => '99999999',
                'accepte_ordonnances' => 'on',
                'en_ligne' => 'on',
                'horaires_lv_start' => '09:00',
                'horaires_lv_end' => '20:00',
                'horaires_sa_start' => '09:00',
                'horaires_sa_end' => '12:00',
            ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->pharmacie->refresh();

        $this->assertEquals('New Name', $this->pharmacie->nom_officine);
        $this->assertEquals('New Owner', $this->pharmacie->pharmacien_titulaire);
        $this->assertTrue($this->pharmacie->accepte_ordonnances);
        $this->assertTrue($this->pharmacie->en_ligne);
        $this->assertEquals([
            'lundi_vendredi' => '09:00 - 20:00',
            'samedi' => '09:00 - 12:00'
        ], $this->pharmacie->horaires_ouverture);
    }
}

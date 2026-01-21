<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SpecialitesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $specialites = [
            ['nom' => 'Cardiologie', 'description' => 'Maladies du cœur et des vaisseaux sanguins'],
            ['nom' => 'Pédiatrie', 'description' => 'Santé des enfants'],
            ['nom' => 'Gynécologie', 'description' => 'Santé de la femme'],
            ['nom' => 'Dermatologie', 'description' => 'Maladies de la peau'],
            ['nom' => 'Ophtalmologie', 'description' => 'Maladies de l’œil'],
            ['nom' => 'Neurologie', 'description' => 'Maladies du système nerveux'],
            ['nom' => 'Psychiatrie', 'description' => 'Santé mentale'],
            ['nom' => 'Chirurgie Générale', 'description' => 'Interventions chirurgicales courantes'],
            ['nom' => 'Orthopédie', 'description' => 'Maladies des os et des articulations'],
            ['nom' => 'Médecine Générale', 'description' => 'Soins de santé primaires'],
            ['nom' => 'Dentiste', 'description' => 'Soins dentaires'],
            ['nom' => 'ORL', 'description' => 'Oto-rhino-laryngologie'],
            ['nom' => 'Urologie', 'description' => 'Maladies des voies urinaires'],
            ['nom' => 'Pneumologie', 'description' => 'Maladies des poumons'],
            ['nom' => 'Endocrinologie', 'description' => 'Maladies hormonales'],
        ];

        DB::table('specialites')->insert($specialites);
    }
}

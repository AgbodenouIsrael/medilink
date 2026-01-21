<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Admin::updateOrCreate(
            ['email' => 'iagbodenou@gmail.com'],
            [
                'nom' => 'Agbodenou',
                'prenom' => 'Israel',
                'password' => 'JockerBmf08', // Le cast 'hashed' dans le modèle s'occupera du hachage
            ]
        );
    }
}

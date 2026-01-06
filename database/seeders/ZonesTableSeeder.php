<?php

namespace Database\Seeders;

use App\Models\Zone;
use Illuminate\Database\Seeder;

class ZonesTableSeeder extends Seeder
{
    public function run(): void
    {
        $zones = [
            ['nom' => 'Lomé Centre', 'ville' => 'Lomé'],
            ['nom' => 'Lomé Bè', 'ville' => 'Lomé'],
            ['nom' => 'Lomé Agoè', 'ville' => 'Lomé'],
            ['nom' => 'Lomé Tokoin', 'ville' => 'Lomé'],
            ['nom' => 'Lomé Nyékonakpoè', 'ville' => 'Lomé'],
            ['nom' => 'Kpalimé Centre', 'ville' => 'Kpalimé'],
            ['nom' => 'Sokodé Centre', 'ville' => 'Sokodé'],
            ['nom' => 'Kara Centre', 'ville' => 'Kara'],
            ['nom' => 'Dapaong Centre', 'ville' => 'Dapaong'],
            ['nom' => 'Aného Centre', 'ville' => 'Aného'],
            ['nom' => 'Atakpamé Centre', 'ville' => 'Atakpamé'],
            ['nom' => 'Tsévié Centre', 'ville' => 'Tsévié'],
            ['nom' => 'Vogan Centre', 'ville' => 'Vogan'],
            ['nom' => 'Notsé Centre', 'ville' => 'Notsé'],
            ['nom' => 'Badou Centre', 'ville' => 'Badou'],
        ];

        foreach ($zones as $zone) {
            Zone::create($zone);
        }
        
        $this->command->info(count($zones) . ' zones créées avec succès !');
    }
}
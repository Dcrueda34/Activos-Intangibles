<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class PaisSeeder extends Seeder
{
    public function run(): void
    {
        // Leer JSON
        $json = File::get(database_path('seeders/data/countries.json'));
        $countries = json_decode($json, true);

        foreach ($countries as $country) {
            // Insertar país si no existe
            $exists = DB::table('pais')->where('Nombre', $country['name'])->exists();
            if (!$exists) {
                DB::table('pais')->insert([
                    'Nombre' => $country['name'],
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }
        }
    }
}

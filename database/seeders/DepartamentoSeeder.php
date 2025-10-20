<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class DepartamentoSeeder extends Seeder
{
    public function run(): void
    {
        // Leer el JSON
        $json = File::get(database_path('seeders/data/countries.json'));
        $countries = json_decode($json, true);

        foreach ($countries as $country) {
            // Buscar el país ya insertado en la tabla 'pais'
            $pais = DB::table('pais')->where('Nombre', $country['name'])->first();

            if (!$pais) {
                // Insertar país si no existe
                $paisId = DB::table('pais')->insertGetId([
                    'Nombre' => $country['name'],
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            } else {
                $paisId = $pais->ID_Pais;
            }

            if (!empty($country['states'])) {
                foreach ($country['states'] as $state) {
                    // Insertar departamento si no existe
                    $exists = DB::table('departamento')
                        ->where('Nombre', $state['name'])
                        ->where('FK_ID_Pais', $paisId)
                        ->exists();

                    if (!$exists) {
                        DB::table('departamento')->insert([
                            'Nombre' => $state['name'],
                            'FK_ID_Pais' => $paisId,
                            'created_at' => now(),
                            'updated_at' => now()
                        ]);
                    }
                }
            }
        }
    }
}

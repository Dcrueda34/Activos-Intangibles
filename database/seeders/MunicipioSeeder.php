<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class MunicipioSeeder extends Seeder
{
    public function run(): void
    {
        // Leer JSON
        $json = File::get(database_path('seeders/data/countries.json'));
        $countries = json_decode($json, true);

        foreach ($countries as $country) {
            // Buscar país en la tabla
            $pais = DB::table('pais')->where('Nombre', $country['name'])->first();
            if (!$pais) continue;

            if (!empty($country['states'])) {
                foreach ($country['states'] as $state) {
                    // Buscar departamento en la tabla
                    $departamento = DB::table('departamento')
                        ->where('Nombre', $state['name'])
                        ->where('FK_ID_Pais', $pais->ID_Pais)
                        ->first();

                    if (!$departamento) continue;

                    if (!empty($state['cities'])) {
                        foreach ($state['cities'] as $city) {
                            // Insertar municipio si no existe
                            $exists = DB::table('municipio')
                                ->where('Nombre', $city)
                                ->where('FK_ID_Departamento', $departamento->ID_Departamento)
                                ->exists();

                            if (!$exists) {
                                DB::table('municipio')->insert([
                                    'Nombre' => $city,
                                    'FK_ID_Departamento' => $departamento->ID_Departamento,
                                    'created_at' => now(),
                                    'updated_at' => now()
                                ]);
                            }
                        }
                    }
                }
            }
        }
    }
}

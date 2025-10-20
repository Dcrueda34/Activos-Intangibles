<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use App\Models\Pais;
use App\Models\Departamento;
use App\Models\Municipio;

class UbicacionSeeder extends Seeder
{
    public function run(): void
    {
        ini_set('memory_limit', '1024M');
        set_time_limit(0);

        $path = database_path('seeders/data/countries+states+cities.json');

        if (!File::exists($path)) {
            $this->command->error("❌ Archivo JSON no encontrado en $path");
            return;
        }

        $json = File::get($path);
        $data = json_decode($json, true);

        if (!$data) {
            $this->command->error("❌ Error al decodificar el JSON.");
            return;
        }

        foreach ($data as $paisItem) {
            // Crear país
            $pais = Pais::create([
                'Nombre' => $paisItem['name'],
            ]);

            // Revisar si hay estados (departamentos)
            if (isset($paisItem['states']) && is_array($paisItem['states'])) {
                foreach ($paisItem['states'] as $estadoItem) {
                    $departamento = Departamento::create([
                        'Nombre' => $estadoItem['name'],
                        'FK_ID_Pais' => $pais->ID_Pais,
                    ]);

                    // Revisar si hay ciudades
                    if (isset($estadoItem['cities']) && is_array($estadoItem['cities'])) {
                        foreach ($estadoItem['cities'] as $cityItem) {
                            Municipio::create([
                                'Nombre' => $cityItem['name'],
                                'FK_ID_Departamento' => $departamento->ID_Departamento,
                            ]);
                        }
                    }
                }
            }

            // Mostrar avance en consola
            $this->command->info("✅ País cargado: {$pais->Nombre}");
        }

        $this->command->info("🎉 Datos de ubicación cargados correctamente desde countries+states+cities.json.");
    }
}

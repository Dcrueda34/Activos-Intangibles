<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('valoraciones', function (Blueprint $table) {
            $table->id('ID_Valoracion');
            $table->unsignedBigInteger('FK_ID_Proyecto');

            // Campos principales del módulo
            $table->string('nombre_producto')->nullable();
            $table->integer('cantidad_vender')->nullable();
            $table->decimal('politica_crecimiento', 10, 2)->nullable();
            $table->decimal('politica_precios', 10, 2)->nullable();
            $table->decimal('precio', 15, 2)->nullable();
            $table->decimal('aumento_costos_anual', 10, 2)->nullable();
            $table->decimal('mano_obra_directa', 15, 2)->nullable();
            $table->decimal('mano_obra_destajo', 15, 2)->nullable();
            $table->decimal('aumento_anual_mod_destajo', 10, 2)->nullable();
            $table->decimal('pago_comision', 10, 2)->nullable();
            $table->decimal('servicios_publicos', 15, 2)->nullable();
            $table->decimal('inversion_maquinaria', 15, 2)->nullable();
            $table->decimal('inversion_muebles', 15, 2)->nullable();
            $table->decimal('inversion_vehiculos', 15, 2)->nullable();
            $table->decimal('inversion_tecnologia', 15, 2)->nullable();
            $table->decimal('porcentaje_aumento_gastos', 10, 2)->nullable();
            $table->decimal('tasa_oportunidad', 10, 2)->nullable();

            $table->timestamps();

            // Relación con Proyecto
            $table->foreign('FK_ID_Proyecto')
                ->references('ID_Proyecto')
                ->on('proyecto')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('valoraciones');
    }
};

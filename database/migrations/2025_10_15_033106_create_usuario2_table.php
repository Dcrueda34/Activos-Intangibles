<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('usuario2', function (Blueprint $table) {
            $table->increments('ID_Usuario');
            $table->string('Nombre', 150);
            $table->string('Apellido', 150);
            $table->string('Telefono', 50);
            $table->string('Correo', 190)->unique();
            $table->string('Contraseña', 190);
            $table->unsignedBigInteger('FK_ID_Municipio'); // <-- CORREGIDO
            $table->timestamps();

            $table->foreign('FK_ID_Municipio')
                ->references('ID_Municipio')
                ->on('municipio')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('usuario2');
    }
};

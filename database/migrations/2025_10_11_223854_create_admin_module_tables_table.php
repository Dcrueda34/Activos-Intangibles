<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        /**
         * 1️⃣ Tabla de usuarios
         */
        if (!Schema::hasTable('admin_module_tables')) {
            Schema::create('admin_module_tables', function (Blueprint $table) {
                $table->id('ID_Usuario');
                $table->string('nombre');
                $table->string('apellido');
                $table->string('telefono')->nullable();
                $table->string('correo')->nullable();
                $table->integer('FK_ID_Rol');
                $table->timestamps();
            });
        }

        /**
         * 2️⃣ Tabla de países
         */
        if (!Schema::hasTable('pais')) {
            Schema::create('pais', function (Blueprint $table) {
                $table->id('ID_Pais');
                $table->string('Nombre', 150);
                $table->timestamps();
            });
        }

        /**
         * 3️⃣ Tabla de departamentos
         */
        if (!Schema::hasTable('departamento')) {
            Schema::create('departamento', function (Blueprint $table) {
                $table->id('ID_Departamento');
                $table->string('Nombre', 150);
                $table->unsignedBigInteger('FK_ID_Pais');
                $table->foreign('FK_ID_Pais')
                    ->references('ID_Pais')
                    ->on('pais')
                    ->onDelete('cascade');
                $table->timestamps();
            });
        }

        /**
         * 4️⃣ Tabla de municipios
         */
        if (!Schema::hasTable('municipio')) {
            Schema::create('municipio', function (Blueprint $table) {
                $table->id('ID_Municipio');
                $table->string('Nombre', 150);
                $table->unsignedBigInteger('FK_ID_Departamento');
                $table->foreign('FK_ID_Departamento')
                    ->references('ID_Departamento')
                    ->on('departamento')
                    ->onDelete('cascade');
                $table->timestamps();
            });
        }

        /**
         * 5️⃣ Tabla de proyectos
         */
        if (!Schema::hasTable('proyecto')) {
            Schema::create('proyecto', function (Blueprint $table) {
                $table->id('ID_Proyecto');
                $table->string('nombre');
                $table->date('fecha')->nullable();
                $table->text('descripcion')->nullable();
                $table->string('certificado')->nullable();
                $table->tinyInteger('liquidado')->default(0);
                $table->timestamps();
            });
        }

        /**
         * 6️⃣ Tabla intermedia proyecto_usuario
         */
        if (!Schema::hasTable('proyecto_usuario')) {
            Schema::create('proyecto_usuario', function (Blueprint $table) {
                $table->unsignedBigInteger('FK_ID_Usuario');
                $table->unsignedBigInteger('FK_ID_Proyecto');
                $table->primary(['FK_ID_Usuario', 'FK_ID_Proyecto']);

                $table->foreign('FK_ID_Usuario')
                    ->references('ID_Usuario')
                    ->on('admin_module_tables')
                    ->onDelete('cascade');

                $table->foreign('FK_ID_Proyecto')
                    ->references('ID_Proyecto')
                    ->on('proyecto')
                    ->onDelete('cascade');
            });
        }

        /**
         * 7️⃣ Tabla de inversiones
         */
        if (!Schema::hasTable('inversion')) {
            Schema::create('inversion', function (Blueprint $table) {
                $table->id('ID_Inversion');
                $table->unsignedBigInteger('FK_ID_Usuario');
                $table->tinyInteger('FK_ID_Tipo'); // 1=dinero,2=especie,3=industria
                $table->decimal('monto', 15, 2);
                $table->date('fecha')->nullable();
                $table->timestamps();

                $table->foreign('FK_ID_Usuario')
                    ->references('ID_Usuario')
                    ->on('admin_module_tables')
                    ->onDelete('cascade');
            });
        }

        /**
         * 8️⃣ Tabla de tasas
         */
        if (!Schema::hasTable('tasa')) {
            Schema::create('tasa', function (Blueprint $table) {
                $table->id('id');
                $table->decimal('tasa', 5, 2);
                $table->timestamps();
            });
        }

        /**
         * 9️⃣ Tabla de empresas
         */
        if (!Schema::hasTable('empresas')) {
            Schema::create('empresas', function (Blueprint $table) {
                $table->id();
                $table->string('nombre');
                $table->string('nit', 100)->nullable();
                $table->date('fecha')->nullable();
                $table->text('descripcion')->nullable();
                $table->string('certificado')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('empresas');
        Schema::dropIfExists('tasa');
        Schema::dropIfExists('inversion');
        Schema::dropIfExists('proyecto_usuario');
        Schema::dropIfExists('proyecto');
        Schema::dropIfExists('municipio');
        Schema::dropIfExists('departamento');
        Schema::dropIfExists('pais');
        Schema::dropIfExists('admin_module_tables');
    }
};
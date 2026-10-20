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
        if (! Schema::hasTable('medical_histories')) {
            Schema::create('medical_histories', function (Blueprint $table) {
                $table->increments('id');
                $table->unsignedInteger('id_mascota');
                $table->date('fecha');
                $table->text('descripcion');
                $table->text('notas')->nullable();
                $table->timestamps();

                $table->foreign('id_mascota')
                    ->references('id_mascota')
                    ->on('mascotas')
                    ->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medical_histories');
    }
};

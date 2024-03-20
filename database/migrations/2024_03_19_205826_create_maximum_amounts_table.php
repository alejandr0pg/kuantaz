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
        Schema::create('montos_maximos', function (Blueprint $table) {
            $table->integer('id_beneficio')->unique(true);
            $table->integer('monto_minimo')->default(0);
            $table->integer('monto_maximo')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('montos_maximos');
    }
};

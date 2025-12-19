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
        Schema::create('ruas_jalans', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('panjang')->nullable();
            $table->string('fungsi')->nullable();
            $table->string('kecamatan')->nullable();
            $table->string('wilayah')->nullable();
            $table->string('no_ruas')->nullable();
            $table->string('jumlah_titik')->nullable();
            $table->longText('polyline');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ruas_jalans');
    }
};

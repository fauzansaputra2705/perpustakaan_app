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
        Schema::create('denda_peminjams', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('peminjam_id')->unsigned();
            $table->bigInteger('tarif_denda_id')->unsigned();
            $table->timestamps();

            $table->foreign('peminjam_id')->references('id')->on('peminjams');
            $table->foreign('tarif_denda_id')->references('id')->on('tarif_dendas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('denda_peminjams');
    }
};

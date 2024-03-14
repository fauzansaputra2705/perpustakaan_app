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
        Schema::create('log_peminjams', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('peminjam_id')->unsigned();
            $table->bigInteger('petugas_id')->unsigned();
            $table->string('status_peminjam');
            $table->text('keterangan_peminjam')->nullable();
            $table->string('kondisi_buku');
            $table->timestamps();

            $table->foreign('peminjam_id')->references('id')->on('peminjams');
            $table->foreign('petugas_id')->references('id')->on('petugas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('log_peminjams');
    }
};

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
        Schema::create('peminjams', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('anggota_id')->unsigned();
            $table->bigInteger('tarif_denda_id')->unsigned()->nullable();
            $table->date('tanggal_pinjam');
            $table->date('tanggal_kembali');
            $table->integer('lama_pinjam');
            $table->text('keterangan');
            $table->enum('kondisi_buku', ['baik', 'rusak', 'hilang']);
            $table->enum('status', ['dipinjam', 'dikembalikan', 'denda', 'telat']);
            $table->timestamps();

            $table->foreign('anggota_id')->references('id')->on('anggotas');
            $table->foreign('tarif_denda_id')->references('id')->on('tarif_dendas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peminjams');
    }
};

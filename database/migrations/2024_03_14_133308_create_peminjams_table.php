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
            $table->bigInteger('buku_id')->unsigned();
            $table->date('tanggal_pinjam');
            $table->date('tanggal_kembali')->nullable();
            $table->integer('lama_pinjam');
            $table->text('keterangan');
            $table->enum('kondisi_buku_minjam', ['baik', 'rusak', 'hilang']);
            $table->enum('kondisi_buku_kembali', ['baik', 'rusak', 'hilang'])->nullable();
            $table->enum('status', ['dipinjam', 'dikembalikan']);
            $table->timestamps();

            $table->foreign('anggota_id')->references('id')->on('anggotas');
            $table->foreign('buku_id')->references('id')->on('bukus');
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

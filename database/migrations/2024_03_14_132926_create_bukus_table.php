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
        Schema::create('bukus', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->bigInteger('kategori_id')->unsigned();
            $table->bigInteger('rak_buku_id')->unsigned();
            $table->string('isbn')->unique();
            $table->string('writer');
            $table->string('reviewer');
            $table->string('translator');
            $table->string('adapter');
            $table->string('cover_designer');
            $table->string('designer');
            $table->string('ilustrator');
            $table->string('editor');
            $table->string('publisher');
            $table->integer('jumlah_halaman');
            $table->integer('jumlah_stok');
            $table->integer('tahun_terbit');
            $table->text('sinopsis');
            $table->string('gambar');
            $table->boolean('status_publish');
            $table->timestamps();

            $table->foreign('kategori_id')->references('id')->on('kategoris');
            $table->foreign('rak_buku_id')->references('id')->on('rak_bukus');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bukus');
    }
};

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
            $table->bigInteger('kategori_id')->unsigned();
            $table->bigInteger('rak_buku_id')->unsigned()->nullable();
            $table->string('title');
            $table->string('slug')->unique();
            $table->date('publish_date');
            $table->text('sinopsis');
            $table->string('publisher');
            $table->string('author');
            $table->string('language');
            $table->string('isbn')->unique()->nullable();
            $table->integer('jumlah_stok');
            $table->integer('tahun_terbit');
            $table->string('cover');
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

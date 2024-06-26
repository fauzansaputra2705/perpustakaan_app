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
        Schema::create('petugas', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned();
            $table->string('kode_petugas')->unique();
            $table->string('email')->unique();
            $table->string('nama');
            $table->enum('jenis_kelamin', ['laki-laki', 'perempuan']);
            $table->string('telpon');
            $table->text('alamat');
            $table->string('foto')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('petugas');
    }
};

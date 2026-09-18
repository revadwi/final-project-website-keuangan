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
        Schema::create('hutangs', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal_dibuat');
            $table->string('nomor_urut');
            $table->string('jenis_hutang'); // from static list
            $table->string('kreditur');
            $table->text('keterangan')->nullable();
            $table->date('jatuh_tempo')->nullable();
            $table->decimal('nominal_awal', 20, 2);
            $table->decimal('bunga_persen', 5, 2)->default(0);
            $table->string('status')->default('Belum Lunas'); // Belum Lunas, Lunas
            $table->unsignedBigInteger('perusahaan_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hutangs');
    }
};

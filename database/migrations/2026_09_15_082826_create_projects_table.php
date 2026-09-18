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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('perusahaan_id')->constrained()->cascadeOnDelete();
            $table->date('tanggal_project');
            $table->integer('tenggang_waktu')->default(0);
            $table->date('tanggal_jatuh_tempo')->nullable();
            $table->string('no_penawaran')->nullable();
            $table->string('nama_pelanggan')->nullable();
            $table->string('nama_perusahaan')->nullable();
            $table->string('nama_project');
            $table->text('deskripsi_project')->nullable();
            $table->bigInteger('harga_dasar')->default(0);
            $table->bigInteger('ppn')->default(0);
            $table->bigInteger('pph_final')->default(0);
            $table->bigInteger('nominal_project')->default(0);
            $table->string('status')->default('Belum Bayar');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};

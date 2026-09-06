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
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id();
            $table->enum('jenis_transaksi', ['Pemasukan', 'Pengeluaran']);
            $table->date('tanggal');
            $table->foreignId('akun_debit_id')->constrained('akuns')->onDelete('cascade');
            $table->foreignId('akun_kredit_id')->constrained('akuns')->onDelete('cascade');
            $table->string('keterangan');
            $table->decimal('jumlah', 15, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};

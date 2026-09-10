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
        Schema::table('kategoris', function (Blueprint $table) {
            $table->foreignId('perusahaan_id')->nullable()->constrained('perusahaans')->onDelete('cascade');
        });
        Schema::table('akuns', function (Blueprint $table) {
            $table->foreignId('perusahaan_id')->nullable()->constrained('perusahaans')->onDelete('cascade');
        });
        Schema::table('transaksis', function (Blueprint $table) {
            $table->foreignId('perusahaan_id')->nullable()->constrained('perusahaans')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transaksis', function (Blueprint $table) {
            $table->dropForeign(['perusahaan_id']);
            $table->dropColumn('perusahaan_id');
        });
        Schema::table('akuns', function (Blueprint $table) {
            $table->dropForeign(['perusahaan_id']);
            $table->dropColumn('perusahaan_id');
        });
        Schema::table('kategoris', function (Blueprint $table) {
            $table->dropForeign(['perusahaan_id']);
            $table->dropColumn('perusahaan_id');
        });
    }
};

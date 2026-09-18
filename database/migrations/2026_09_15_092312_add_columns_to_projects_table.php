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
        Schema::table('projects', function (Blueprint $table) {
            $table->string('kota')->nullable()->after('nama_perusahaan');
            $table->decimal('pph_final', 5, 2)->default(0)->change();
            $table->bigInteger('pendapatan_bersih')->default(0)->after('nominal_project');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn(['kota', 'pendapatan_bersih']);
            $table->bigInteger('pph_final')->default(0)->change();
        });
    }
};

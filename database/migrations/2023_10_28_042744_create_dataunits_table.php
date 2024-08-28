<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('dataunits', function (Blueprint $table) {
            $table->string('no_faktur', 100)->primary();
            $table->string('nama_sales', 50);
            $table->string('nama_supervisor', 50);
            $table->string('nama_customer', 50);
            $table->string('material_type', 30);
            $table->dateTime('tanggal_faktur');
            $table->text('alur_proses_penjualan');
            $table->string('warna_plat', 20);
            $table->string('nama_leasing', 50);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dataunits');
    }
};

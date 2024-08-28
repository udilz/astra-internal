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
        Schema::create('prosesstnk_status', function (Blueprint $table) {
            $table->dateTime('tanggal_status_prosesstnk')->primary()->default(now());
            $table->string('prosesstnk_plat_nomor', 100);
            $table->foreign('prosesstnk_plat_nomor')->references('plat_nomor')->on('prosesstnks')->onDelete('cascade');
            $table->integer('status_id');
            $table->string('keterangan', 100);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prosesstnk_status');
    }
};

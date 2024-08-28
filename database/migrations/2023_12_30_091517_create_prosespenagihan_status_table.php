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
        Schema::create('prosespenagihan_status', function (Blueprint $table) {
            $table->dateTime('tanggal_status_penagihan')->primary()->default(now());
            $table->string('prosespenagihan_no_tagihan', 100);
            $table->foreign('prosespenagihan_no_tagihan')->references('no_tagihan')->on('prosespenagihans')->onDelete('cascade');
            $table->foreignId('status_id')->constrained('statuses');
            $table->string('keterangan', 100);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prosespenagihan_status');
    }
};

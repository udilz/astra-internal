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
        Schema::create('prosespenagihans', function (Blueprint $table) {
            $table->string('no_tagihan', 100)->primary();
            $table->dateTime('jatuh_tempo');
            $table->string('payment_type', 50);
            $table->text('dokumen')->nullable();
            $table->string('dataunit_no_faktur', 100);
            $table->foreign('dataunit_no_faktur')->references('no_faktur')->on('dataunits')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prosespenagihans');
    }
};

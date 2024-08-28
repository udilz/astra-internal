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
        Schema::create('kirimunits', function (Blueprint $table) {
            $table->string('no_rangka', 100)->primary();
            $table->string('no_mesin', 50);
            $table->string('lokasi_tujuan', 100);
            $table->string('dataunit_no_faktur', 100);
            $table->foreign('dataunit_no_faktur')->references('no_faktur')->on('dataunits')->onDelete('cascade');
            $table->text('dokumen')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kirimunits');
    }
};

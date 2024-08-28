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
        Schema::create('prosesstnks', function (Blueprint $table) {
            $table->string('plat_nomor', 100)->primary();
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

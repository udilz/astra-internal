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
        Schema::create('kirimunit_status', function (Blueprint $table) {
            $table->dateTime('tanggal_status_kirimunit')->primary()->default(now());
            $table->string('kirimunit_no_rangka', 100);
            $table->foreign('kirimunit_no_rangka')->references('no_rangka')->on('kirimunits')->onDelete('cascade');
            $table->foreignId('status_id')->constrained('statuses');
            $table->string('keterangan', 100);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kirimunit_status');
    }
};

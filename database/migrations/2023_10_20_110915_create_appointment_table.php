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
        Schema::create('appointment', function (Blueprint $table) {
            $table->string('appointment_id')->primary();
            $table->date('date');
            $table->string('time');           
            $table->string('status');
            $table->integer('num_of_handsides_for_bridal_package');
            $table->integer('num_of_handsides_for_non_bridal_package');
            $table->string('delivery_area');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointment');
    }
};

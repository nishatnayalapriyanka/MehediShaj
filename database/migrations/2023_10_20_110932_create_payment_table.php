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
        Schema::create('payment', function (Blueprint $table) {
             $table->string('appointment_id')->primary();
             $table->string('payment_transaction_id');
             $table->double('total_booking_fee');
             $table->string('total_service_charge');
             $table->string('status');
             $table->string('artist_compensation_status');
             $table->string('refund_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment');
    }
};

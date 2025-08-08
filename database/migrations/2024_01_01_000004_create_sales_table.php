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
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('affiliate_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('program_id')->constrained()->onDelete('cascade');
            $table->string('tracking_code')->comment('Tracking code used');
            $table->string('customer_name')->comment('Customer name');
            $table->string('customer_email')->comment('Customer email');
            $table->string('customer_phone')->nullable()->comment('Customer phone');
            $table->decimal('sale_amount', 10, 2)->comment('Sale amount');
            $table->decimal('commission_rate', 5, 2)->comment('Commission percentage at time of sale');
            $table->decimal('commission_amount', 10, 2)->comment('Commission amount earned');
            $table->enum('status', ['pending', 'confirmed', 'cancelled'])->default('pending')->comment('Sale status');
            $table->timestamp('sale_date')->comment('Date of sale');
            $table->timestamps();
            
            // Indexes for performance
            $table->index('affiliate_id');
            $table->index('program_id');
            $table->index('tracking_code');
            $table->index('status');
            $table->index('sale_date');
            $table->index(['affiliate_id', 'status']);
            $table->index(['affiliate_id', 'sale_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
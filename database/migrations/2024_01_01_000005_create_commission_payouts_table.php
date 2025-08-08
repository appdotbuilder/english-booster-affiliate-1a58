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
        Schema::create('commission_payouts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('affiliate_id')->constrained('users')->onDelete('cascade');
            $table->decimal('amount', 10, 2)->comment('Payout amount');
            $table->enum('status', ['pending', 'processing', 'paid', 'cancelled'])->default('pending')->comment('Payout status');
            $table->text('notes')->nullable()->comment('Payout notes');
            $table->timestamp('processed_at')->nullable()->comment('When payout was processed');
            $table->timestamps();
            
            // Indexes for performance
            $table->index('affiliate_id');
            $table->index('status');
            $table->index('processed_at');
            $table->index(['affiliate_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commission_payouts');
    }
};
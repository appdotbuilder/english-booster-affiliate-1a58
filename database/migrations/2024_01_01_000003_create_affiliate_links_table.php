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
        Schema::create('affiliate_links', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('program_id')->constrained()->onDelete('cascade');
            $table->string('tracking_code')->unique()->comment('Unique tracking code');
            $table->string('link_url')->comment('Full affiliate link URL');
            $table->integer('clicks')->default(0)->comment('Number of clicks');
            $table->timestamps();
            
            // Indexes for performance
            $table->index('user_id');
            $table->index('program_id');
            $table->index('tracking_code');
            $table->index(['user_id', 'program_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('affiliate_links');
    }
};
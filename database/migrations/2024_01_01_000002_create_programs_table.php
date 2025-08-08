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
        Schema::create('programs', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('Program name');
            $table->text('description')->nullable()->comment('Program description');
            $table->enum('category', ['online', 'offline_pare', 'group', 'branch'])->comment('Program category');
            $table->string('location')->nullable()->comment('Location for branch programs');
            $table->decimal('price', 10, 2)->comment('Program price');
            $table->decimal('commission_percentage', 5, 2)->default(10.00)->comment('Commission percentage for affiliates');
            $table->boolean('is_active')->default(true)->comment('Whether program is active');
            $table->timestamps();
            
            // Indexes for performance
            $table->index('category');
            $table->index('is_active');
            $table->index(['category', 'is_active']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('programs');
    }
};
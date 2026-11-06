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
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();

            $table->foreignId('campus_id')
                ->constrained('campuses')
                ->restrictOnDelete();

            $table->foreignId('order_id')
                ->constrained()
                ->restrictOnDelete();

            $table->foreignId('product_id')
                ->constrained()
                ->restrictOnDelete();

            $table->foreignId('unit_id')
                ->constrained('units')
                ->restrictOnDelete();

            // Historical snapshots.
            $table->string('product_name');
            $table->string('unit_symbol', 20);

            $table->decimal('quantity', 15, 3);
            $table->decimal('conversion_factor', 15, 6)->default(1);

            // Optional custom glass dimensions.
            $table->decimal('width', 15, 3)->nullable();
            $table->decimal('height', 15, 3)->nullable();
            $table->decimal('area', 15, 3)->nullable();

            $table->decimal('unit_price', 15, 3);
            $table->decimal('total', 15, 3);

            $table->timestamps();

            $table->index(['campus_id', 'order_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};

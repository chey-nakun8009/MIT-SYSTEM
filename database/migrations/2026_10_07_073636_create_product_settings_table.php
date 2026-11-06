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
        Schema::create('product_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('campus_id')->constrained('campuses')->cascadeOnDelete();
            $table->enum('default_product_type', [
                'standard',
                'glass',
            ])->default('standard');
            $table->foreignId('default_unit_id')->nullable()->constrained('units')->nullOnDelete();
            $table->unsignedTinyInteger('decimal_places')->default(3);
            $table->boolean('allow_negative_stock')->default(false);
            $table->boolean('allow_inactive_sales')->default(false);
            $table->boolean('require_sku')->default(true);
            $table->boolean('auto_generate_sku')->default(false);
            $table->decimal('low_stock_threshold', 12, 3)->default(0);
            $table->timestamps();
            $table->unique('campus_id');
            $table->index(['campus_id', 'default_product_type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_settings');
    }
};

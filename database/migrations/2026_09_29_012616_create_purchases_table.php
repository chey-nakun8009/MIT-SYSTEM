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
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();

            $table->foreignId('campus_id')
                ->constrained('campuses')
                ->restrictOnDelete();

            $table->foreignId('supplier_id')
                ->constrained()
                ->restrictOnDelete();

            $table->string('purchase_number');
            $table->string('supplier_invoice_number')->nullable();

            $table->date('purchase_date');

            $table->string('status')->default('draft');
            // draft, received, cancelled

            $table->decimal('subtotal', 15, 3)->default(0);
            $table->decimal('discount', 15, 3)->default(0);
            $table->decimal('shipping_cost', 15, 3)->default(0);
            $table->decimal('total', 15, 3)->default(0);

            $table->text('notes')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->unique(['campus_id', 'purchase_number']);
            $table->index(['campus_id', 'supplier_id', 'purchase_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchases');
    }
};

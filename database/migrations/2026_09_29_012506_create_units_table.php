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
        Schema::create('units', function (Blueprint $table) {
            $table->id();

            $table->foreignId('campus_id')
                ->nullable()
                ->constrained('campuses')
                ->restrictOnDelete();
            $table->string('name', 100);
            $table->string('symbol', 20);
            $table->string('type', 30);
            $table->unsignedTinyInteger('decimal_places')->default(3);
            $table->timestamps();
            $table->index(['campus_id', 'symbol']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('units');
    }
};

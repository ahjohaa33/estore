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
        Schema::create('cart_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cart_id')->constrained('carts')->cascadeOnDelete();
            $table->foreignId('product_id')->constrained('products')->restrictOnDelete();

            // Keep options dead-simple to match your schema
            $table->string('color')->nullable();
            $table->string('size')->nullable();

            $table->unsignedInteger('qty')->default(1);
            $table->decimal('unit_price', 10, 2);           // snapshot at add-time

            $table->timestamps();

            // One line per product+option set
            $table->unique(['cart_id','product_id','color','size']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cart_items');
    }
};

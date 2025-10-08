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
        Schema::create('products', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->text('images')->nullable();        // Stored as JSON string
            $table->text('color')->nullable();         // Stored as JSON string
            $table->text('size')->nullable();          // Stored as JSON string
            $table->string('category')->nullable();
            $table->decimal('price', 10, 2)->default(0);
            $table->decimal('offer_price', 10, 2)->nullable();
            $table->dateTime('offer_duration')->nullable();
            $table->unsignedInteger('sale_count')->default(0);
            $table->text('specification')->nullable();
            $table->integer('is_fav')->default(0);
            $table->boolean('in_stock')->default(1);
            $table->boolean('is_featured')->default(0);
            $table->string('status')->default('active');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};

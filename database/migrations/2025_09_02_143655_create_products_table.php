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
            $table->string('name'); // Product Name
            $table->json('images')->nullable(); // multiple images
            $table->string('category'); 
            $table->string('price'); // could be decimal(10,2) if strict money handling
            $table->string('size')->nullable();
            $table->text('specification')->nullable();
            $table->boolean('is_fav')->default(false);
            $table->integer('in_stock')->default(0);
            $table->enum('status', ['in_stock', 'out_of_stock', 'pre_order'])->default('in_stock');
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

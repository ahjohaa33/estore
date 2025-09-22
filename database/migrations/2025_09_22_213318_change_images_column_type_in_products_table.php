<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            // Change images column to TEXT (good enough for JSON in SQLite)
            $table->text('images')->change();
        });
    }

    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            // Rollback: if it was string before
            $table->string('images')->change();
        });
    }
};

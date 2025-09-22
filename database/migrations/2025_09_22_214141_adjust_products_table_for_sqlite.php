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
            // SQLite does not support decimal, so we use float
            $table->float('offer_price')->nullable()->after('price')->change();

            // SQLite does not support json, so we use text
            $table->text('color_variations')->nullable()->after('offer_price')->change();

            // // Ensure images is text so it can hold JSON arrays
            // $table->text('images')->change();
        });
    }

    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            // Rollback to original (if needed)
            $table->dropColumn(['offer_price', 'color_variations']);
            // $table->string('images')->change();
        });
    }
};

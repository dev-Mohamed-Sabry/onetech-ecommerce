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
        Schema::table('recently_viewed_products', function (Blueprint $table) {
            $table->timestamp('last_viewed_at')
                ->nullable()
                ->after('product_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('recently_viewed_products', function (Blueprint $table) {
            //
        });
    }
};

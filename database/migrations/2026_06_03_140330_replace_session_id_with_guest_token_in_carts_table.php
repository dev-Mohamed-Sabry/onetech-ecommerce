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
        Schema::table('carts', function (Blueprint $table) {
            $table->dropColumn('session_id');

            $table->string('guest_token')->nullable()->index()->after('user_id');

            // نفس المنتج لا يتكرر لنفس الزائر
            $table->unique(['guest_token', 'product_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('carts', function (Blueprint $table) {
            $table->dropColumn('guest_token');
            $table->string('session_id', 128)->nullable()->index()->after('user_id');
            $table->unique(['session_id', 'product_id']);
        });
    }
};

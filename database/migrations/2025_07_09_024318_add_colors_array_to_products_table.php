<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->json('colors')->nullable()->after('color');
        });

        // Convert existing color values to JSON arrays
        $products = DB::table('products')->get();
        foreach ($products as $product) {
            if ($product->color) {
                DB::table('products')
                    ->where('id', $product->id)
                    ->update(['colors' => json_encode([$product->color])]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('colors');
        });
    }
};

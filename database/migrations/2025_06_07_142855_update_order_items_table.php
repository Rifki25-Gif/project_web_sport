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
        Schema::table('order_items', function (Blueprint $table) {
            // Hapus kolom lama jika ada
            if (Schema::hasColumn('order_items', 'size')) {
                $table->dropColumn('size');
            }
            if (Schema::hasColumn('order_items', 'total')) {
                $table->dropColumn('total');
            }
            
            // Tambah kolom baru
            if (!Schema::hasColumn('order_items', 'subtotal')) {
                $table->decimal('subtotal', 10, 2)->after('price');
            }
            if (!Schema::hasColumn('order_items', 'options')) {
                $table->json('options')->nullable()->after('subtotal');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            // Hapus kolom baru
            if (Schema::hasColumn('order_items', 'subtotal')) {
                $table->dropColumn('subtotal');
            }
            if (Schema::hasColumn('order_items', 'options')) {
                $table->dropColumn('options');
            }
            
            // Tambah kolom lama
            if (!Schema::hasColumn('order_items', 'size')) {
                $table->string('size')->nullable();
            }
            if (!Schema::hasColumn('order_items', 'total')) {
                $table->decimal('total', 10, 2);
            }
        });
    }
};

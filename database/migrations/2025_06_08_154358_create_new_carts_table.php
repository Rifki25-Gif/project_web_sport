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
        // Periksa apakah tabel carts sudah ada
        if (Schema::hasTable('carts')) {
            // Tambahkan atau ubah kolom yang diperlukan pada tabel carts yang sudah ada
            Schema::table('carts', function (Blueprint $table) {
                // Tambahkan kolom baru jika belum ada
                if (!Schema::hasColumn('carts', 'total')) {
                    $table->decimal('total', 10, 2)->nullable()->after('coupon_value');
                }
                
                // Tambahkan indeks jika belum ada
                if (!Schema::hasIndex('carts', 'carts_user_id_session_id_is_checked_out_index')) {
                    $table->index(['user_id', 'session_id', 'is_checked_out']);
                }
            });
        } else {
            // Buat tabel carts baru jika belum ada
            Schema::create('carts', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
                $table->string('session_id')->nullable();
                $table->boolean('is_checked_out')->default(false);
                $table->string('coupon_code')->nullable();
                $table->decimal('coupon_value', 10, 2)->nullable();
                $table->decimal('total', 10, 2)->nullable();
                $table->timestamps();
                
                // Add index for faster lookups
                $table->index(['user_id', 'session_id', 'is_checked_out']);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Jangan hapus tabel carts, hanya hapus kolom yang ditambahkan
        if (Schema::hasTable('carts') && Schema::hasColumn('carts', 'total')) {
            Schema::table('carts', function (Blueprint $table) {
                $table->dropColumn('total');
                // Hapus indeks jika ada
                if (Schema::hasIndex('carts', 'carts_user_id_session_id_is_checked_out_index')) {
                    $table->dropIndex('carts_user_id_session_id_is_checked_out_index');
                }
            });
        }
    }
};

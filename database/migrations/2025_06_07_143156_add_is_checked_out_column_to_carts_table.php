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
            // Ubah user_id menjadi nullable (untuk cart guest) jika belum nullable
            if (Schema::hasColumn('carts', 'user_id')) {
                $table->foreignId('user_id')->nullable()->change();
            }
            
            // Periksa apakah kolom product_id ada sebelum mencoba menghapusnya
            if (Schema::hasColumn('carts', 'product_id')) {
                // Periksa apakah foreign key ada sebelum mencoba menghapusnya
                $foreignKeys = Schema::getConnection()->getDoctrineSchemaManager()->listTableForeignKeys('carts');
                $hasForeignKey = false;
                
                foreach ($foreignKeys as $foreignKey) {
                    if (in_array('product_id', $foreignKey->getLocalColumns())) {
                        $hasForeignKey = true;
                        $table->dropForeign($foreignKey->getName());
                        break;
                    }
                }
                
                // Hapus kolom jika ada
                $table->dropColumn('product_id');
            }
            
            // Hapus kolom quantity dan size jika ada
            if (Schema::hasColumn('carts', 'quantity')) {
                $table->dropColumn('quantity');
            }
            
            if (Schema::hasColumn('carts', 'size')) {
                $table->dropColumn('size');
            }
            
            // Tambahkan kolom baru jika belum ada
            if (!Schema::hasColumn('carts', 'session_id')) {
                $table->string('session_id')->nullable()->after('user_id');
            }
            
            if (!Schema::hasColumn('carts', 'is_checked_out')) {
                $table->boolean('is_checked_out')->default(false)->after('session_id');
            }
            
            if (!Schema::hasColumn('carts', 'coupon_code')) {
                $table->string('coupon_code')->nullable()->after('is_checked_out');
            }
            
            if (!Schema::hasColumn('carts', 'coupon_value')) {
                $table->decimal('coupon_value', 10, 2)->nullable()->after('coupon_code');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('carts', function (Blueprint $table) {
            // Hapus kolom yang ditambahkan jika ada
            $columnsToDrop = [];
            
            if (Schema::hasColumn('carts', 'session_id')) {
                $columnsToDrop[] = 'session_id';
            }
            
            if (Schema::hasColumn('carts', 'is_checked_out')) {
                $columnsToDrop[] = 'is_checked_out';
            }
            
            if (Schema::hasColumn('carts', 'coupon_code')) {
                $columnsToDrop[] = 'coupon_code';
            }
            
            if (Schema::hasColumn('carts', 'coupon_value')) {
                $columnsToDrop[] = 'coupon_value';
            }
            
            if (!empty($columnsToDrop)) {
                $table->dropColumn($columnsToDrop);
            }
        });
    }
};

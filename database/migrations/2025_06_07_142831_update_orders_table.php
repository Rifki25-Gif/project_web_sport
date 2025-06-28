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
        // Check if the table has the necessary columns before modifying
        if (Schema::hasTable('orders')) {
            // Check if the table has the expected structure
            if (!Schema::hasColumn('orders', 'shipping_address')) {
                // Add shipping_address column if it doesn't exist
                Schema::table('orders', function (Blueprint $table) {
                    $table->json('shipping_address')->nullable()->after('status');
                });
            }
            
            // Add new columns
            Schema::table('orders', function (Blueprint $table) {
                if (!Schema::hasColumn('orders', 'payment_method')) {
                    $table->string('payment_method')->nullable()->after('shipping_address');
                }
                
                if (!Schema::hasColumn('orders', 'payment_details')) {
                    $table->json('payment_details')->nullable()->after('payment_method');
                }
                
                if (!Schema::hasColumn('orders', 'subtotal')) {
                    $table->decimal('subtotal', 10, 2)->nullable()->after('payment_details');
                }
                
                if (!Schema::hasColumn('orders', 'discount')) {
                    $table->decimal('discount', 10, 2)->default(0)->after('subtotal');
                }
                
                if (!Schema::hasColumn('orders', 'tax')) {
                    $table->decimal('tax', 10, 2)->nullable()->after('discount');
                }
                
                // Rename total_amount to total if it exists
                if (Schema::hasColumn('orders', 'total_amount') && !Schema::hasColumn('orders', 'total')) {
                    $table->renameColumn('total_amount', 'total');
                } elseif (!Schema::hasColumn('orders', 'total')) {
                    $table->decimal('total', 10, 2)->nullable()->after('tax');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('orders')) {
            Schema::table('orders', function (Blueprint $table) {
                // Drop added columns
                if (Schema::hasColumn('orders', 'payment_method')) {
                    $table->dropColumn('payment_method');
                }
                
                if (Schema::hasColumn('orders', 'payment_details')) {
                    $table->dropColumn('payment_details');
                }
                
                if (Schema::hasColumn('orders', 'subtotal')) {
                    $table->dropColumn('subtotal');
                }
                
                if (Schema::hasColumn('orders', 'discount')) {
                    $table->dropColumn('discount');
                }
                
                if (Schema::hasColumn('orders', 'tax')) {
                    $table->dropColumn('tax');
                }
                
                // Rename total back to total_amount if it exists
                if (Schema::hasColumn('orders', 'total') && !Schema::hasColumn('orders', 'total_amount')) {
                    $table->renameColumn('total', 'total_amount');
                }
            });
        }
    }
};

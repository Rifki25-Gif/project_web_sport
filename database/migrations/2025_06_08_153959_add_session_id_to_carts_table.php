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
            // Add session_id column if it doesn't exist
            if (!Schema::hasColumn('carts', 'session_id')) {
                $table->string('session_id')->nullable()->after('user_id');
            }
            
            // Add is_checked_out column if it doesn't exist
            if (!Schema::hasColumn('carts', 'is_checked_out')) {
                $table->boolean('is_checked_out')->default(false)->after('session_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('carts', function (Blueprint $table) {
            // Drop columns if they exist
            if (Schema::hasColumn('carts', 'session_id')) {
                $table->dropColumn('session_id');
            }
            
            if (Schema::hasColumn('carts', 'is_checked_out')) {
                $table->dropColumn('is_checked_out');
            }
        });
    }
};

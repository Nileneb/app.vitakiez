<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Rename 'name' column to 'wg_name' in wgs table
        Schema::table('wgs', function (Blueprint $table) {
            $table->renameColumn('name', 'wg_name');
        });

        // Rename primary key 'id' to 'wg_id' in wgs table
        Schema::table('wgs', function (Blueprint $table) {
            $table->renameColumn('id', 'wg_id');
        });

        // Update foreign key references in users table (active_wg_id remains the same, just the target changed)
        // No change needed - FK constraint already uses 'id' reference which is now 'wg_id'
        
        // Update foreign key references in cases table
        Schema::table('cases', function (Blueprint $table) {
            $table->dropForeign(['wg_id']);
        });
        
        Schema::table('cases', function (Blueprint $table) {
            $table->foreign('wg_id')->references('wg_id')->on('wgs')->cascadeOnDelete();
        });

        // Update unique constraint to use wg_name instead of name
        Schema::table('wgs', function (Blueprint $table) {
            $table->dropUnique(['owner_user_id', 'name']);
        });
        
        Schema::table('wgs', function (Blueprint $table) {
            $table->unique(['owner_user_id', 'wg_name']);
        });
    }

    public function down(): void
    {
        Schema::table('wgs', function (Blueprint $table) {
            $table->dropUnique(['owner_user_id', 'wg_name']);
        });

        Schema::table('wgs', function (Blueprint $table) {
            $table->unique(['owner_user_id', 'name']);
        });

        Schema::table('cases', function (Blueprint $table) {
            $table->dropForeign(['wg_id']);
        });

        Schema::table('cases', function (Blueprint $table) {
            $table->foreign('wg_id')->references('id')->on('wgs')->cascadeOnDelete();
        });

        Schema::table('wgs', function (Blueprint $table) {
            $table->renameColumn('wg_id', 'id');
        });

        Schema::table('wgs', function (Blueprint $table) {
            $table->renameColumn('wg_name', 'name');
        });
    }
};

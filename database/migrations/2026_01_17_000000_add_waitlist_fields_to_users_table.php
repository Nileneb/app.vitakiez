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
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone')->nullable()->after('email');
            $table->string('user_type')->nullable()->after('password'); // 'bewohner', 'investor', or null
            $table->string('pflegegrad')->nullable()->after('user_type');
            $table->string('einzug')->nullable()->after('pflegegrad');
            $table->text('nachricht')->nullable()->after('einzug');
            $table->string('interesse')->nullable()->after('nachricht'); // for investors
            $table->string('betrag')->nullable()->after('interesse'); // for investors
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'phone',
                'user_type',
                'pflegegrad',
                'einzug',
                'nachricht',
                'interesse',
                'betrag',
            ]);
        });
    }
};

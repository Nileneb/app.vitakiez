<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('wgs', function (Blueprint $table) {
            $table->string('n8n_api_key', 128)->nullable()->after('notes');
        });
    }

    public function down(): void
    {
        Schema::table('wgs', function (Blueprint $table) {
            $table->dropColumn('n8n_api_key');
        });
    }
};

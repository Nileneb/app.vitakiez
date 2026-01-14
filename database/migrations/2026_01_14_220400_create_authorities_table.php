<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('authorities', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->enum('authority_type', [
                'CARE_FUND','HEALTH_INSURER','SOCIAL_WELFARE_OFFICE','CARE_SUPPORT_CENTER',
                'HEIMAUFSICHT_WTG','BUILDING_AUTHORITY','FIRE_DEPARTMENT','HEALTH_DEPARTMENT',
                'DATA_PROTECTION_AUTH','COURT_GUARDIANSHIP','CONSUMER_CENTER','OTHER'
            ]);

            $table->string('name');
            $table->string('jurisdiction_state')->nullable();
            $table->string('jurisdiction_district')->nullable();
            $table->string('jurisdiction_municipality')->nullable();
            $table->string('coverage_note')->nullable();

            $table->string('website_url')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('address_text')->nullable();
            $table->string('office_hours')->nullable();

            $table->text('notes')->nullable();
            $table->timestampTz('last_verified_at')->nullable();

            $table->timestampsTz();

            $table->index(['authority_type', 'jurisdiction_state']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('authorities');
    }
};

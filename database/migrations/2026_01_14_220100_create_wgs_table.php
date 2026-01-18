<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('wgs', function (Blueprint $table) {
            $table->uuid('wg_id')->primary();

            $table->foreignId('owner_user_id')->constrained('users')->cascadeOnDelete();

            $table->string('wg_name');
            $table->string('address_text')->nullable();
            $table->string('state');         // Bundesland
            $table->string('district')->nullable();
            $table->string('municipality')->nullable();

            $table->enum('governance', ['SELF_ORGANIZED', 'PROVIDER_ORGANIZED', 'MIXED', 'UNKNOWN'])->default('UNKNOWN');

            $table->unsignedSmallInteger('residents_total')->default(0);
            $table->unsignedSmallInteger('residents_with_pg')->default(0);

            $table->string('target_group')->nullable();

            $table->boolean('has_24h_presence')->default(false);
            $table->boolean('has_presence_staff')->default(false);

            $table->enum('care_provider_mode', ['FREE_CHOICE', 'SINGLE_PROVIDER', 'INHOUSE', 'MIXED', 'UNKNOWN'])->default('UNKNOWN');

            $table->boolean('lease_individual')->default(false);
            $table->boolean('care_individual')->default(false);
            $table->boolean('bundle_housing_care')->default(false);

            $table->boolean('sgb_xi_used')->default(false);
            $table->boolean('sgb_xii_involved')->default(false);
            $table->boolean('sgb_v_hkp')->default(false);

            $table->string('landesrecht_title')->nullable();
            $table->string('landesrecht_url')->nullable();
            $table->string('heimaufsicht_contact_hint')->nullable();

            $table->text('notes')->nullable();
            $table->string('n8n_api_key', 128)->nullable();

            $table->timestampsTz();

            $table->unique(['owner_user_id', 'wg_name']);
            $table->index(['state', 'governance']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('wgs');
    }
};

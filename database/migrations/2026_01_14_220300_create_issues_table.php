<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('issues', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('code')->unique();   // WG_ZUSCHLAG_38A ...
            $table->string('name');
            $table->text('description')->nullable();

            $table->text('default_authority_targets')->nullable(); // Übergang (später normalisieren)
            $table->text('default_required_docs')->nullable();
            $table->text('default_next_actions')->nullable();
            $table->text('default_source_links')->nullable();
            $table->text('rule_hints')->nullable();

            $table->timestampsTz();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('issues');
    }
};

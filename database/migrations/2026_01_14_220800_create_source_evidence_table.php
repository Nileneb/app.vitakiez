<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('source_evidence', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->foreignUuid('case_id')->constrained('cases')->cascadeOnDelete();
            $table->foreignUuid('issue_id')->nullable()->constrained('issues')->nullOnDelete();

            $table->string('url');
            $table->string('domain')->nullable();

            $table->enum('source_type', ['OFFICIAL','LAW','AUTHORITY','INSURER','CONSUMER','ASSOCIATION','OTHER'])->default('OTHER');
            $table->enum('jurisdiction_scope', ['FEDERAL','STATE','EU','MUNICIPAL','OTHER'])->default('OTHER');

            $table->text('title')->nullable();

            $table->text('evidence_excerpt')->nullable();
            $table->text('claim_supported')->nullable();

            $table->unsignedSmallInteger('authority_score')->default(0);
            $table->unsignedSmallInteger('relevance_score')->default(0);
            $table->unsignedSmallInteger('jurisdiction_score')->default(0);
            $table->unsignedSmallInteger('total_score')->default(0);

            $table->unsignedSmallInteger('http_status')->nullable();
            $table->timestampTz('checked_at')->nullable();

            $table->boolean('selected')->default(false);

            // Volltext / Pfad (für RAG)
            $table->longText('text_full')->nullable();
            $table->string('text_path')->nullable();
            $table->string('content_hash')->nullable();

            $table->timestampsTz();

            $table->unique(['case_id', 'url']);
            $table->index(['case_id', 'selected', 'total_score']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('source_evidence');
    }
};

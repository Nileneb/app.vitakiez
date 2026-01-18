<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('cases', function (Blueprint $table) {
            $table->uuid('case_id')->primary();

            $table->foreignUuid('wg_id')->constrained('wgs', 'wg_id')->cascadeOnDelete();
            $table->foreignId('created_by_user_id')->constrained('users')->cascadeOnDelete();

            $table->string('case_title');
            $table->enum('status', ['OPEN','IN_PROGRESS','WAITING','DONE','ARCHIVED'])->default('OPEN');
            $table->text('problem_description');

            $table->enum('priority', ['LOW','MEDIUM','HIGH','CRITICAL'])->default('MEDIUM');

            // Übergangsfelder (bis UI/Normalisierung vollständig ist)
            $table->text('required_docs')->nullable();   // semikolon / json später
            $table->text('next_actions')->nullable();
            $table->text('deadlines')->nullable();       // "YYYY-MM-DD|..." ; später separate Tabelle
            $table->text('source_links')->nullable();
            $table->text('attachments')->nullable();

            $table->string('evaluated')->default('false');
            $table->timestampTz('last_reviewed_at')->nullable();

            $table->timestampsTz();

            $table->index(['wg_id', 'status', 'priority']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cases');
    }
};

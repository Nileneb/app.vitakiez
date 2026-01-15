<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Rename 'title' to 'case_title' in cases table
        Schema::table('cases', function (Blueprint $table) {
            $table->renameColumn('title', 'case_title');
        });

        // Rename primary key 'id' to 'case_id'
        Schema::table('cases', function (Blueprint $table) {
            $table->renameColumn('id', 'case_id');
        });

        // Update foreign key references in case_issue table
        Schema::table('case_issue', function (Blueprint $table) {
            $table->dropForeign(['case_id']);
        });
        
        Schema::table('case_issue', function (Blueprint $table) {
            $table->foreign('case_id')->references('case_id')->on('cases')->cascadeOnDelete();
        });

        // Update foreign key references in case_authority table
        Schema::table('case_authority', function (Blueprint $table) {
            $table->dropForeign(['case_id']);
        });
        
        Schema::table('case_authority', function (Blueprint $table) {
            $table->foreign('case_id')->references('case_id')->on('cases')->cascadeOnDelete();
        });

        // Update foreign key references in source_evidence table
        Schema::table('source_evidence', function (Blueprint $table) {
            $table->dropForeign(['case_id']);
        });
        
        Schema::table('source_evidence', function (Blueprint $table) {
            $table->foreign('case_id')->references('case_id')->on('cases')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('source_evidence', function (Blueprint $table) {
            $table->dropForeign(['case_id']);
        });
        
        Schema::table('source_evidence', function (Blueprint $table) {
            $table->foreign('case_id')->references('id')->on('cases')->cascadeOnDelete();
        });

        Schema::table('case_authority', function (Blueprint $table) {
            $table->dropForeign(['case_id']);
        });
        
        Schema::table('case_authority', function (Blueprint $table) {
            $table->foreign('case_id')->references('id')->on('cases')->cascadeOnDelete();
        });

        Schema::table('case_issue', function (Blueprint $table) {
            $table->dropForeign(['case_id']);
        });
        
        Schema::table('case_issue', function (Blueprint $table) {
            $table->foreign('case_id')->references('id')->on('cases')->cascadeOnDelete();
        });

        Schema::table('cases', function (Blueprint $table) {
            $table->renameColumn('case_id', 'id');
        });

        Schema::table('cases', function (Blueprint $table) {
            $table->renameColumn('case_title', 'title');
        });
    }
};

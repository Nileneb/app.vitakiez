<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('case_issue', function (Blueprint $table) {
            $table->uuid('case_id');
            $table->uuid('issue_id');
            $table->primary(['case_id','issue_id']);

            $table->foreign('case_id')->references('case_id')->on('cases')->cascadeOnDelete();
            $table->foreign('issue_id')->references('id')->on('issues')->cascadeOnDelete();

            $table->timestampsTz();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('case_issue');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('case_authority', function (Blueprint $table) {
            $table->uuid('case_id');
            $table->uuid('authority_id');
            $table->primary(['case_id','authority_id']);

            $table->foreign('case_id')->references('case_id')->on('cases')->cascadeOnDelete();
            $table->foreign('authority_id')->references('id')->on('authorities')->cascadeOnDelete();

            $table->timestampsTz();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('case_authority');
    }
};

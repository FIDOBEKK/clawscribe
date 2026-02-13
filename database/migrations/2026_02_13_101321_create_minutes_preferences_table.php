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
        Schema::create('minutes_preferences', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            $table->longText('instructions')->nullable();

            // Convenience fields for the currently active template (derived from uploaded doc / or manual text).
            $table->longText('template_extracted_text')->nullable();
            $table->string('template_filename')->nullable();
            $table->string('template_mime_type')->nullable();

            $table->timestamps();

            $table->unique('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('minutes_preferences');
    }
};

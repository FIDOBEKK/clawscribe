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
        Schema::create('minutes', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            $table->dateTime('occurred_at');
            $table->string('title');
            $table->longText('markdown');

            $table->string('source_file_id')->nullable();
            $table->string('drive_referat_path')->nullable();
            $table->string('drive_audio_path')->nullable();

            $table->timestamps();

            $table->index(['user_id', 'occurred_at']);
            $table->unique(['user_id', 'source_file_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('minutes');
    }
};

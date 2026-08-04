<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('characters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('novel_id')->constrained()->onDelete('cascade');
            $table->unsignedBigInteger('faction_id')->nullable();
            $table->string('name');
            $table->string('cultivation_realm')->default('Unknown');
            $table->string('role')->nullable();
            $table->text('description')->nullable();
            $table->string('status')->default('Alive');
            $table->timestamps();
        });

        Schema::create('chapter_character', function (Blueprint $table) {
            $table->id();
            $table->foreignId('chapter_id')->constrained()->onDelete('cascade');
            $table->foreignId('character_id')->constrained()->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('chapter_character');
        Schema::dropIfExists('characters');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rotating_professions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('hero_section_id');
            $table->string('profession');
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->foreign('hero_section_id')->references('id')->on('hero_sections')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rotating_professions');
    }
};

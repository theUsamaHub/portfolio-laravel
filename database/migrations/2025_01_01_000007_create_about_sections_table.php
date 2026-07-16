<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('about_sections', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('title')->default('About Me');
            $table->string('subtitle')->nullable();
            $table->text('description');
            $table->json('highlights')->nullable();
            $table->string('profile_image')->nullable();
            $table->integer('experience_years')->nullable();
            $table->string('location')->nullable();
            $table->json('languages')->nullable();
            $table->string('cv_file')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('about_sections');
    }
};

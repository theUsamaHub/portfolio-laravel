<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('skills', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('skill_category_id');
            $table->string('name');
            $table->string('slug');
            $table->string('icon')->nullable();
            $table->integer('percentage')->nullable();
            $table->text('description')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();

            $table->foreign('skill_category_id')->references('id')->on('skill_categories')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('skills');
    }
};

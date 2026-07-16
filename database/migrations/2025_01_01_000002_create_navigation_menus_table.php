<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('navigation_menus', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('label');
            $table->string('url')->nullable();
            $table->string('icon')->nullable();
            $table->uuid('parent_id')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->boolean('open_in_new_tab')->default(false);
            $table->timestamps();
        });

        Schema::table('navigation_menus', function (Blueprint $table) {
            $table->foreign('parent_id')->references('id')->on('navigation_menus')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('navigation_menus');
    }
};

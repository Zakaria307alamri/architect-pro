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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
    
            // ===== Hero Section =====
            $table->string('hero_title')->nullable();
            $table->text('hero_subtitle')->nullable();
    
            // ===== About Page =====
            $table->string('about_headline')->nullable();
            $table->text('about_description')->nullable();
            $table->string('profile_name')->nullable();
            $table->string('profile_title')->nullable();
    
            // ===== Contact =====
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('location')->nullable();
    
            // ===== Social Media =====
            $table->string('instagram')->nullable();
            $table->string('behance')->nullable();
            $table->string('linkedin')->nullable();
    
            // ===== SEO =====
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
    
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};

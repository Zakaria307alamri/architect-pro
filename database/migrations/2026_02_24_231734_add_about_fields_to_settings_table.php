<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('settings', function (Blueprint $table) {

            $table->string('about_hero_title')->nullable();
            $table->text('about_hero_subtitle')->nullable();

            $table->string('profile_image')->nullable();

            $table->string('profile_section_title')->nullable();

            $table->string('philosophy_title')->nullable();
            $table->text('philosophy_text')->nullable();

            $table->string('experience_title')->nullable();
            $table->longText('experience_list')->nullable();

            $table->string('about_cta_title')->nullable();
            $table->text('about_cta_subtitle')->nullable();
            $table->string('about_cta_button')->nullable();

        });
    }

    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {

            $table->dropColumn([
                'about_hero_title',
                'about_hero_subtitle',
                'profile_image',
                'profile_section_title',
                'philosophy_title',
                'philosophy_text',
                'experience_title',
                'experience_list',
                'about_cta_title',
                'about_cta_subtitle',
                'about_cta_button',
            ]);

        });
    }
};

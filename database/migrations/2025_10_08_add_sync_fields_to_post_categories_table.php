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
        Schema::table('post_categories', function (Blueprint $table) {
            // Add SEO fields
            $table->string('seo_title')->nullable()->after('status');
            $table->text('seo_description')->nullable()->after('seo_title');
            $table->text('seo_keywords')->nullable()->after('seo_description');
            
            // Add featured image
            $table->string('featured_image')->nullable()->after('seo_keywords');
            
            // Add tags field
            $table->text('tags')->nullable()->after('featured_image');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('post_categories', function (Blueprint $table) {
            $table->dropColumn(['seo_title', 'seo_description', 'seo_keywords', 'featured_image', 'tags']);
        });
    }
};
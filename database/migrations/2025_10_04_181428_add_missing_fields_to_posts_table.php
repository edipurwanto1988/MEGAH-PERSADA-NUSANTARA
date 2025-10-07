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
        Schema::table('posts', function (Blueprint $table) {
            // Add excerpt field
            $table->text('excerpt')->nullable()->after('content');
            
            // Add status field
            $table->enum('status', ['draft', 'published'])->default('draft')->after('excerpt');
            
            // Add published_at field (different from published_date)
            $table->dateTime('published_at')->nullable()->after('status');
            
            // Rename published_date to published_date_original to avoid confusion
            // Or we can drop it if published_at is sufficient
            // For now, let's keep both but make published_date nullable
            $table->dateTime('published_date')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn(['excerpt', 'status', 'published_at']);
            // Optionally revert published_date to not nullable if needed
        });
    }
};

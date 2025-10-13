<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('post_categories', function (Blueprint $table) {
            // Make name field nullable temporarily
            $table->string('name')->nullable()->change();
        });
        
        // Copy data from category_name to name for existing records
        DB::statement('UPDATE post_categories SET name = category_name WHERE name IS NULL');
        
        Schema::table('post_categories', function (Blueprint $table) {
            // Make name field not nullable again
            $table->string('name')->nullable(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No need to reverse as this is just fixing data
    }
};
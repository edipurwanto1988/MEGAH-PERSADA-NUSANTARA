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
            // Add name field to match model expectation
            $table->string('name')->after('id');
            
            // Add status field
            $table->boolean('status')->default(1)->after('description');
            
            // Copy data from category_name to name
            // This will be handled in a separate step or through a seeder
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('post_categories', function (Blueprint $table) {
            $table->dropColumn(['name', 'status']);
        });
    }
};

<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::firstOrCreate(
            ['email' => 'test@example.com'],
            ['name' => 'Test User', 'password' => bcrypt('password'), 'role' => 'user']
        );
        
        // Create admin user
        User::firstOrCreate(
            ['email' => 'admin@megahjaya.com'],
            ['name' => 'Admin User', 'password' => bcrypt('admin123'), 'role' => 'admin']
        );
        
        // Call other seeders
        $this->call([
            CompanyProfileSeeder::class,
            ProductSeeder::class,
            ArticleSeeder::class,
        ]);
    }
}

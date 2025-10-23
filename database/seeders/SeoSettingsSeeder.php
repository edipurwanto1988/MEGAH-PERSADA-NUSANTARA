<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SeoSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $seoSettings = [
            'og_title' => 'Jasa Web Pekanbaru - Profesional Pembuatan Website',
            'og_description' => 'Jasa pembuatan pembuatan website, desain, aplikasi, SEO dengan harga bersaing dan kualitas di Pekanbaru',
            'og_image' => 'https://images.unsplash.com/photo-1467232004584-a241de8bcf5d?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=600&q=80.png',
            'og_url' => 'https://jasawebpekanbaru.com',
            'og_site_name' => 'Jasa Web Pekanbaru',
            'twitter_title' => 'Jasa Web Pekanbaru - Profesional Web Development Services',
            'twitter_description' => 'Penyedia jasa pembuatan website, desain, aplikasi, SEO, blog dengan harga bersaing dan kualitas terjamin',
            'twitter_image' => 'https://images.unsplash.com/photo-1467232004584-a241de8bcf5d?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=600&q=80.png',
            'meta_title' => 'Jasa Web Pekanbaru - Profesional Pembuatan Website',
            'meta_description' => 'Jasa pembuatan pembuatan website, desain, aplikasi, SEO dengan harga bersaing dan kualitas di Pekanbaru',
            'meta_keywords' => 'jasa web pekanbaru, pembuatan website, desain web, aplikasi web, SEO pekanbaru, web development'
        ];

        foreach ($seoSettings as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        $this->command->info('SEO settings seeded successfully.');
    }
}
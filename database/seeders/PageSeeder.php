<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pages = [
            [
                'title' => 'About Us',
                'slug' => 'about-us',
                'content' => '<h2>About Megah Persada Nusantara</h2><p>Megah Persada Nusantara is a leading distributor of high-quality products for a better life. We are committed to providing the best products and services to our customers.</p><p>With years of experience in the industry, we have built a reputation for excellence, reliability, and customer satisfaction.</p>',
                'featured_image' => 'https://picsum.photos/seed/about/800/600.jpg',
                'status' => 'published',
                'seo_title' => 'About Us - Megah Persada Nusantara',
                'seo_description' => 'Learn more about Megah Persada Nusantara, our mission, values, and commitment to excellence.',
                'seo_keywords' => 'about, company, megah persada nusantara',
            ],
            [
                'title' => 'Contact Us',
                'slug' => 'contact-us',
                'content' => '<h2>Contact Information</h2><p>Get in touch with us for any inquiries or support.</p><p><strong>Address:</strong> Jl. Sudirman No. 123, Jakarta Pusat, Indonesia<br><strong>Phone:</strong> +62 21 1234 5678<br><strong>Email:</strong> info@megahpersada.com</p>',
                'featured_image' => 'https://picsum.photos/seed/contact/800/600.jpg',
                'status' => 'published',
                'seo_title' => 'Contact Us - Megah Persada Nusantara',
                'seo_description' => 'Contact Megah Persada Nusantara for inquiries, support, or business opportunities.',
                'seo_keywords' => 'contact, address, phone, email',
            ],
            [
                'title' => 'Terms of Service',
                'slug' => 'terms-of-service',
                'content' => '<h2>Terms of Service</h2><p>By using our website and services, you agree to the following terms and conditions.</p><p>Please read these terms carefully before using our services.</p>',
                'featured_image' => 'https://picsum.photos/seed/terms/800/600.jpg',
                'status' => 'published',
                'seo_title' => 'Terms of Service - Megah Persada Nusantara',
                'seo_description' => 'Terms of Service for Megah Persada Nusantara website and services.',
                'seo_keywords' => 'terms, service, legal, agreement',
            ],
            [
                'title' => 'Privacy Policy',
                'slug' => 'privacy-policy',
                'content' => '<h2>Privacy Policy</h2><p>We are committed to protecting your privacy and personal information.</p><p>This policy explains how we collect, use, and protect your data.</p>',
                'featured_image' => 'https://picsum.photos/seed/privacy/800/600.jpg',
                'status' => 'published',
                'seo_title' => 'Privacy Policy - Megah Persada Nusantara',
                'seo_description' => 'Privacy Policy for Megah Persada Nusantara website and data protection.',
                'seo_keywords' => 'privacy, policy, data, protection',
            ],
        ];

        foreach ($pages as $page) {
            Page::firstOrCreate(
                ['slug' => $page['slug']],
                $page
            );
        }
    }
}
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CompanyProfile;

class CompanyProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CompanyProfile::create([
            'company_name' => 'Mega Hjaya',
            'logo' => 'images/logo_megah_persada_nusantara.svg',
            'description' => 'Mega Hjaya is a leading distributor of high-quality products for a better life. We are committed to providing the best products and services to our customers.',
            'address' => 'Jl. Sudirman No. 123, Jakarta Pusat, Indonesia',
            'phone' => '+62 21 1234 5678',
            'email' => 'info@megahjaya.com',
            'website' => 'https://megahjaya.com',
            'facebook' => 'https://facebook.com/megahjaya',
            'instagram' => 'https://instagram.com/megahjaya',
            'linkedin' => 'https://linkedin.com/company/megahjaya',
            'youtube' => 'https://youtube.com/megahjaya',
        ]);
    }
}
<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Specification;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get or create a default category
        $category = ProductCategory::firstOrCreate(
            ['category_name' => 'Health Appliances'],
            ['slug' => 'health-appliances', 'description' => 'Health and wellness products']
        );
        
        // Create specifications
        $dimensions = Specification::firstOrCreate(
            ['spec_name' => 'Dimensions'],
            ['description' => 'Product dimensions']
        );
        
        $weight = Specification::firstOrCreate(
            ['spec_name' => 'Weight'],
            ['description' => 'Product weight']
        );
        
        $powerSupply = Specification::firstOrCreate(
            ['spec_name' => 'Power Supply'],
            ['description' => 'Power requirements']
        );
        
        $warranty = Specification::firstOrCreate(
            ['spec_name' => 'Warranty'],
            ['description' => 'Product warranty period']
        );
        
        // Create products
        $products = [
            [
                'product_name' => 'Advanced Health Appliance',
                'slug' => 'advanced-health-appliance',
                'description' => 'The Advanced Health Appliance is designed to enhance your well-being with cutting-edge technology. Its sleek design and user-friendly interface make it a perfect addition to any home.',
                'price' => 2500000,
                'status' => 1,
            ],
            [
                'product_name' => 'Professional Health Monitor',
                'slug' => 'professional-health-monitor',
                'description' => 'Professional-grade monitoring for accurate results. Features advanced sensors and connectivity options for health tracking.',
                'price' => 3200000,
                'status' => 1,
            ],
            [
                'product_name' => 'Compact Health Tracker',
                'slug' => 'compact-health-tracker',
                'description' => 'Compact design for on-the-go health tracking. Perfect for those who want to monitor their health anywhere, anytime.',
                'price' => 1800000,
                'status' => 1,
            ],
            [
                'product_name' => 'Smart Health Assistant',
                'slug' => 'smart-health-assistant',
                'description' => 'AI-powered assistant for personalized health insights. Uses machine learning to provide tailored recommendations.',
                'price' => 4500000,
                'status' => 1,
            ],
            [
                'product_name' => 'Premium Health Kit',
                'slug' => 'premium-health-kit',
                'description' => 'Complete health monitoring kit for comprehensive care. Includes multiple devices and accessories for full health tracking.',
                'price' => 5500000,
                'status' => 1,
            ],
            [
                'product_name' => 'Basic Health Monitor',
                'slug' => 'basic-health-monitor',
                'description' => 'Essential health monitoring at an affordable price. Perfect for beginners who want to start tracking their health.',
                'price' => 1200000,
                'status' => 1,
            ],
            [
                'product_name' => 'Digital Thermometer Pro',
                'slug' => 'digital-thermometer-pro',
                'description' => 'High-precision digital thermometer with fast response time. Suitable for both medical and home use.',
                'price' => 850000,
                'status' => 1,
            ],
            [
                'product_name' => 'Blood Pressure Monitor Plus',
                'slug' => 'blood-pressure-monitor-plus',
                'description' => 'Advanced blood pressure monitor with memory function and irregular heartbeat detection.',
                'price' => 1500000,
                'status' => 1,
            ],
            [
                'product_name' => 'Pulse Oximeter Premium',
                'slug' => 'pulse-oximeter-premium',
                'description' => 'High-accuracy pulse oximeter with OLED display and plethysmograph capability.',
                'price' => 750000,
                'status' => 1,
            ],
            [
                'product_name' => 'Fitness Tracker Ultra',
                'slug' => 'fitness-tracker-ultra',
                'description' => 'All-in-one fitness tracker with heart rate monitoring, sleep tracking, and GPS functionality.',
                'price' => 2000000,
                'status' => 1,
            ],
        ];
        
        foreach ($products as $productData) {
            $product = Product::firstOrCreate(
                ['slug' => $productData['slug']],
                array_merge($productData, ['category_id' => $category->id])
            );
            
            // Attach specifications with values
            $product->specifications()->syncWithoutDetaching([
                $dimensions->id => ['spec_value' => '12 x 10 x 8 inches'],
                $weight->id => ['spec_value' => '5 lbs'],
                $powerSupply->id => ['spec_value' => '110V/220V'],
                $warranty->id => ['spec_value' => '1 Year Limited Warranty']
            ]);
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Post;
use App\Models\Contact;
use App\Models\User;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    /**
     * Display the admin dashboard.
     */
    public function dashboard()
    {
        $totalProducts = Product::where('status', 'active')->count();
        $totalPosts = Post::where('status', 'active')->count();
        $totalContacts = Contact::count();
        $totalUsers = User::count();
        
        // Get latest products (most recently created)
        $latestProducts = Product::with('category')
            ->latest()
            ->take(5)
            ->get();
        
        return view('admin.dashboard', compact('totalProducts', 'totalPosts', 'totalContacts', 'totalUsers', 'latestProducts'));
    }
    
    /**
     * Display the settings page.
     */
    public function settings()
    {
        return view('admin.settings');
    }
    
    /**
     * Update the settings.
     */
    public function updateSettings(Request $request)
    {
        // Define validation rules for all possible fields
        $rules = [
            'site_name' => 'sometimes|required|string|max:255',
            'site_description' => 'nullable|string',
            'site_email' => 'nullable|email|max:255',
            'site_phone' => 'nullable|string|max:20',
            'site_address' => 'nullable|string',
            'whatsapp' => 'nullable|string|max:20',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
            'google_analytics' => 'nullable|string',
            'company_name' => 'nullable|string|max:255',
            'company_description' => 'nullable|string',
            'company_vision' => 'nullable|string',
            'company_mission' => 'nullable|string',
            'company_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
        
        // Only validate fields that are actually present in the request
        $validated = $request->validate(array_intersect_key($rules, $request->all()));
        
        // Update settings for all fields that were submitted
        foreach ($request->all() as $key => $value) {
            // Skip CSRF token and method field
            if (in_array($key, ['_token', '_method'])) {
                continue;
            }
            
            // Check if this field is allowed to be saved
            if (array_key_exists($key, $rules)) {
                // Special handling for whatsapp field to save with correct database key
                $dbKey = $key === 'whatsapp' ? 'whatshapp' : $key;
                
                if ($request->hasFile($key)) {
                    // Handle file uploads
                    $setting = Setting::where('key', $dbKey)->first();
                    if ($setting && $setting->value) {
                        Storage::disk('public')->delete($setting->value);
                    }
                    
                    $path = $request->file($key)->store('settings', 'public');
                    Setting::updateOrCreate(['key' => $dbKey], ['value' => $path]);
                } else {
                    // Handle text values
                    Setting::updateOrCreate(['key' => $dbKey], ['value' => $value]);
                }
            }
        }
        
        return redirect()->back()
            ->with('success', 'Settings updated successfully.');
    }
}

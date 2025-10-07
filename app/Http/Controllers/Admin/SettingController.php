<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\CompanyProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    /**
     * Display the settings page.
     */
    public function index()
    {
        $settings = Setting::all()->pluck('value', 'key')->toArray();
        $companyProfile = CompanyProfile::first();
        
        return view('admin.settings.index', compact('settings', 'companyProfile'));
    }
    
    /**
     * Update the settings.
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'site_name' => 'required|string|max:255',
            'site_description' => 'nullable|string',
            'site_keywords' => 'nullable|string',
            'site_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'site_favicon' => 'nullable|image|mimes:ico,png,jpg,gif|max:1024',
            'contact_email' => 'nullable|email|max:255',
            'contact_phone' => 'nullable|string|max:20',
            'contact_address' => 'nullable|string',
            'social_facebook' => 'nullable|url|max:255',
            'social_twitter' => 'nullable|url|max:255',
            'social_instagram' => 'nullable|url|max:255',
            'social_linkedin' => 'nullable|url|max:255',
            'social_youtube' => 'nullable|url|max:255',
            'google_analytics' => 'nullable|string',
            'google_recaptcha_site_key' => 'nullable|string',
            'google_recaptcha_secret_key' => 'nullable|string',
        ]);
        
        // Update settings
        foreach ($validated as $key => $value) {
            if ($request->hasFile($key)) {
                // Handle file uploads
                $setting = Setting::where('key', $key)->first();
                if ($setting && $setting->value) {
                    Storage::disk('public')->delete($setting->value);
                }
                
                $path = $request->file($key)->store('settings', 'public');
                Setting::updateOrCreate(['key' => $key], ['value' => $path]);
            } else {
                // Handle text values
                Setting::updateOrCreate(['key' => $key], ['value' => $value]);
            }
        }
        
        return redirect()->back()
            ->with('success', 'Settings updated successfully.');
    }
    
    /**
     * Update the company profile.
     */
    public function updateCompanyProfile(Request $request)
    {
        $validated = $request->validate([
            'company_name' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'favicon' => 'nullable|image|mimes:ico,png,jpg,gif|max:1024',
            'address' => 'nullable|string',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'website' => 'nullable|url|max:255',
            'description' => 'nullable|string',
            'vision' => 'nullable|string',
            'mission' => 'nullable|string',
            'working_hours' => 'nullable|string',
            'google_map_embed' => 'nullable|string',
            'facebook_url' => 'nullable|url|max:255',
            'twitter_url' => 'nullable|url|max:255',
            'instagram_url' => 'nullable|url|max:255',
            'linkedin_url' => 'nullable|url|max:255',
            'youtube_url' => 'nullable|url|max:255',
        ]);
        
        $companyProfile = CompanyProfile::first();
        
        if (!$companyProfile) {
            $companyProfile = new CompanyProfile();
        }
        
        // Handle logo upload
        if ($request->hasFile('logo')) {
            if ($companyProfile->logo) {
                Storage::disk('public')->delete($companyProfile->logo);
            }
            
            $logoPath = $request->file('logo')->store('company', 'public');
            $validated['logo'] = $logoPath;
        }
        
        // Handle favicon upload
        if ($request->hasFile('favicon')) {
            if ($companyProfile->favicon) {
                Storage::disk('public')->delete($companyProfile->favicon);
            }
            
            $faviconPath = $request->file('favicon')->store('company', 'public');
            $validated['favicon'] = $faviconPath;
        }
        
        $companyProfile->fill($validated);
        $companyProfile->save();
        
        return redirect()->back()
            ->with('success', 'Company profile updated successfully.');
    }
}

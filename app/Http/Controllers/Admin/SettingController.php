<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Display site settings
     */
    public function index()
    {
        $settings = Setting::all()->groupBy('group');
        return view('admin.settings.index', compact('settings'));
    }

    /**
     * Update site settings
     */
    public function update(Request $request)
    {
        $request->validate([
            'settings' => 'required|array'
        ]);

        foreach ($request->settings as $key => $value) {
            // Handle file uploads
            if ($request->hasFile("settings.{$key}")) {
                $file = $request->file("settings.{$key}");
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('uploads', $filename, 'public');
                $value = 'storage/' . $path;
            }

            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        return response()->json([
            'success' => true,
            'message' => 'Settings updated successfully!'
        ]);
    }

    /**
     * Get settings for API
     */
    public function getSettings()
    {
        $settings = Setting::all()->pluck('value', 'key');
        return response()->json($settings);
    }

    /**
     * Initialize default settings
     */
    public function initializeDefaults()
    {
        $defaultSettings = [
            'hero_title' => [
                'value' => 'Streamline Your Donation Management',
                'type' => 'text',
                'group' => 'hero',
                'description' => 'Main hero title text'
            ],
            'hero_subtitle' => [
                'value' => 'Help nonprofits and charities efficiently track, manage, and optimize their donation processes.',
                'type' => 'textarea',
                'group' => 'hero',
                'description' => 'Hero subtitle/description text'
            ],
            'hero_background' => [
                'value' => 'https://images.unsplash.com/photo-1521791136064-7986c2920216?ixlib=rb-4.0.3',
                'type' => 'image',
                'group' => 'hero',
                'description' => 'Hero background image URL'
            ],
            'demo_video_url' => [
                'value' => 'https://www.youtube.com/embed/ScMzIvxBSi4',
                'type' => 'url',
                'group' => 'demo',
                'description' => 'Demo video URL (YouTube embed format or regular YouTube URL)'
            ],
            'demo_video_title' => [
                'value' => 'See How It Works',
                'type' => 'text',
                'group' => 'demo',
                'description' => 'Demo video modal title'
            ]
        ];

        foreach ($defaultSettings as $key => $config) {
            Setting::updateOrCreate(
                ['key' => $key],
                [
                    'value' => $config['value'],
                    'type' => $config['type'],
                    'group' => $config['group'],
                    'description' => $config['description']
                ]
            );
        }

        return response()->json([
            'success' => true,
            'message' => 'Default settings initialized!'
        ]);
    }
}

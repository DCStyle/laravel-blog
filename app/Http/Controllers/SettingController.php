<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function edit()
    {
        $settings = Setting::all()->pluck('value', 'key');
        return view('settings.edit', compact('settings'));
    }

    public function update(Request $request)
    {
        $keys = [
            'site_name',
            'site_description',
            'site_meta_keywords',
            'contact_email',
            'copyright_text',
            'social_facebook',
            'social_instagram',
            'social_twitter',
            'social_youtube',
        ];

        // Handle file uploads
        if ($request->hasFile('logo')) {
            $logo = $request->file('logo')->store('public/settings');
            Setting::updateOrCreate(
                ['key' => 'logo'],
                ['value' => Storage::url($logo)]
            );
        }

        if ($request->hasFile('favicon')) {
            $favicon = $request->file('favicon')->store('public/settings');
            Setting::updateOrCreate(
                ['key' => 'favicon'],
                ['value' => Storage::url($favicon)]
            );
        }

        foreach ($keys as $key) {
            Setting::updateOrCreate(['key' => $key], ['value' => $request->input($key)]);
        }

        return redirect()->back()->with('success', 'Settings updated successfully.');
    }
}

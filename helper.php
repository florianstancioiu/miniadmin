<?php

use App\Models\Setting;

if (! function_exists('setting')) {
    function setting(string $key): string
    {
        $setting = Setting::where('key', $key)->first();

        return $setting ? $setting->value : '';
    }
}

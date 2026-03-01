<?php

use App\Models\Setting;

if (! function_exists('site_settings')) {
    function site_settings()
    {
        return Setting::first();
    }
}
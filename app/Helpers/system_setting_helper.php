<?php

use App\Models\SystemSetting;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;

if (!function_exists('setting')) {
    function setting(string $key, mixed $default = null, ?int $campusId = null): mixed
    {
        if (!$campusId && Auth::check()) {
            $campusId = Auth::user()->campus_id;
        }

        $campusId = $campusId ?? 1;

        $settings = Cache::remember("system_settings_{$campusId}", now()->addHours(24), function () use ($campusId) {
            return SystemSetting::where('campus_id', $campusId)->pluck('value', 'key')->toArray();
        });

        $value = $settings[$key] ?? $default;

        if ($value === '1' || $value === 'true') {
            return true;
        }
        if ($value === '0' || $value === 'false') {
            return false;
        }

        return $value;
    }
}

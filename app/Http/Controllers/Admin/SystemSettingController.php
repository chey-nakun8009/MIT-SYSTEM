<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Models\SystemSetting;

class SystemSettingController extends Controller
{
    public function index()
    {
        $settings = SystemSetting::where(
            'campus_id',
            Auth::user()->campus_id
        )
            ->get()
            ->keyBy('key');

        return view('admin.system-settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'system_name'              => 'nullable|string|max:255',
            'system_logo'              => 'nullable|image|mimes:png,jpg,jpeg,webp,svg|max:2048',
            'favicon'                  => 'nullable|image|mimes:png,jpg,jpeg,ico,webp|max:1024',
            'logo_width'               => 'nullable|string|max:50',
            'logo_height'              => 'nullable|string|max:50',
            'logo_border_radius'       => 'nullable|string|max:50',
            'brand_text_color'         => 'nullable|string|max:50',
            'brand_font_size'          => 'nullable|string|max:50',
            'primary_color'            => 'nullable|string|max:50',
            'secondary_color'          => 'nullable|string|max:50',
            'english_font'             => 'nullable|string|max:100',
            'khmer_font'               => 'nullable|string|max:100',
            'default_language'         => 'nullable|string|max:10',
            'mail_driver'              => 'nullable|string|max:50',
            'mail_host'                => 'nullable|string|max:255',
            'mail_port'                => 'nullable|string|max:50',
            'mail_encryption'          => 'nullable|string|max:50',
            'mail_from_name'           => 'nullable|string|max:255',
            'mail_username'            => 'nullable|string|max:255',
            'mail_password'            => 'nullable|string|max:255',
            'password_length'          => 'nullable|integer',
            'login_attempt_limit'      => 'nullable|integer',
            'session_timeout'          => 'nullable|integer',
            'two_factor_auth'          => 'nullable',
            'toast_bg_color'           => 'nullable|string|max:50',
            'toast_text_color'         => 'nullable|string|max:50',
            'toast_error_bg_color'     => 'nullable|string|max:50',
            'toast_error_text_color'   => 'nullable|string|max:50',
            'toast_border_radius'      => 'nullable|string|max:50',
            'table_header_color'       => 'nullable|string|max:50',
            'table_header_text_color'  => 'nullable|string|max:50',
            'table_header_alignment'   => 'nullable|string|max:20',
            'table_body_alignment'     => 'nullable|string|max:20',
            'table_th_padding'         => 'nullable|string|max:20',
            'table_td_padding'         => 'nullable|string|max:20',
            'table_th_font_size'       => 'nullable|string|max:20',
            'table_td_font_size'       => 'nullable|string|max:20',
            'button_bg_color'          => 'nullable|string|max:50',
            'button_text_color'        => 'nullable|string|max:50',
            'button_hover_bg'          => 'nullable|string|max:50',
            'btn_secondary_bg'         => 'nullable|string|max:50',
            'btn_secondary_color'      => 'nullable|string|max:50',
            'btn_secondary_hover_bg'   => 'nullable|string|max:50',
            'sidebar_active_bg'        => 'nullable|string|max:50',
            'sidebar_active_color'     => 'nullable|string|max:50',
            'sidebar_hover_bg'         => 'nullable|string|max:50',
            'sidebar_font_size'        => 'nullable|string|max:50',
        ]);

        $campusId = Auth::user()->campus_id;
        if (!$campusId) {
            abort(403, 'User is not assigned to any campus.');
        }
        $data = $request->except('_token', '_method');

        $booleans = ['two_factor_auth'];
        foreach ($booleans as $boolean) {
            if (!isset($data[$boolean])) {
                $data[$boolean] = '0';
            }
        }

        foreach ($data as $key => $value) {
            if ($request->hasFile($key)) {
                $file = $request->file($key);

                $old = SystemSetting::where([
                    'campus_id' => $campusId,
                    'key' => $key
                ])->first();
                if ($old && $old->value && Storage::disk('public')->exists('uploads/system-setting/' . $old->value)) {
                    Storage::disk('public')->delete('uploads/settings/' . $old->value);
                }
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->storeAs('uploads/settings', $filename, 'public');

                $value = $filename;
            } elseif (in_array($key, ['system_logo', 'favicon']) && is_null($value)) {
                continue;
            }

            SystemSetting::updateOrCreate(
                [
                    'campus_id' => $campusId,
                    'key'       => $key
                ],
                [
                    'value' => $value,
                    'type'  => in_array($key, ['system_logo', 'favicon']) ? 'image' : 'text',
                    'group' => $this->getGroup($key)
                ]
            );
        }

        Cache::forget("system_settings_{$campusId}");

        return back()->with('success', 'System settings updated successfully.');
    }

    private function getGroup($key)
    {
        return match (true) {
            in_array($key, ['system_name', 'system_logo', 'favicon', 'logo_width', 'logo_height', 'logo_border_radius', 'brand_text_color', 'brand_font_size']) => 'general',
            in_array($key, ['mail_driver', 'mail_host', 'mail_port', 'mail_encryption', 'mail_from_name', 'mail_username', 'mail_password']) => 'mail',
            in_array($key, ['password_length', 'login_attempts', 'login_attempt_limit', 'session_timeout', 'lockout_time', 'two_factor_auth']) => 'security',
            default => 'theme',
        };
    }
}

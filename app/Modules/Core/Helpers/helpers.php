<?php

use App\Modules\Core\Models\Setting;
use Illuminate\Support\Facades\Schema;

if (!function_exists('setting')) {
    function setting($key, $default = null)
    {
        static $settings = [];

        if (array_key_exists($key, $settings)) {
            return $settings[$key];
        }

        try {
            // Kiểm tra bảng settings đã được migrate chưa
            if (!Schema::hasTable('settings')) {
                return $default;
            }

            $setting = Setting::where('key', $key)->first();
            
            if ($setting) {
                $val = $setting->value;
                
                // Chuẩn hóa kiểu dữ liệu boolean
                if ($val === '1' || $val === 'true') {
                    $val = true;
                } elseif ($val === '0' || $val === 'false') {
                    $val = false;
                }
                
                $settings[$key] = $val;
                return $val;
            }
        } catch (\Exception $e) {
            return $default;
        }

        return $default;
    }
}

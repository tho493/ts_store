<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Modules\Core\Models\Setting;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            [
                'key' => 'enable_shopping_cart',
                'value' => '1', // 1: Bật giỏ hàng (E-commerce), 0: Tắt giỏ hàng (Catalog)
            ],
            [
                'key' => 'hotline',
                'value' => '0987.654.321',
            ],
            [
                'key' => 'zalo_link',
                'value' => 'https://zalo.me/0987654321',
            ],
            [
                'key' => 'messenger_link',
                'value' => 'https://m.me/tsbattery',
            ],
            [
                'key' => 'address',
                'value' => '123 Đường Năng Lượng, Phường Công Nghệ, Quận Cầu Giấy, Hà Nội',
            ]
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(['key' => $setting['key']], ['value' => $setting['value']]);
        }
    }
}

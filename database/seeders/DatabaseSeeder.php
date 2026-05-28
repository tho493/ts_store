<?php

namespace Database\Seeders;

use App\Modules\User\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Sinh user test mặc định
        User::firstOrCreate(
            ['email' => 'admin@tsbattery.com'],
            [
                'name' => 'Admin',
                'password' => bcrypt('password'), // Mật khẩu mặc định
                'role' => 'admin',
            ]
        );

        // Chạy các seeder nghiệp vụ
        $this->call([
            SettingSeeder::class,
            ProductSeeder::class,
        ]);
    }
}

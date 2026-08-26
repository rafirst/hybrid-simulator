<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            [
                'key' => 'app_title',
                'value' => 'CARA KERJA MESIN HYBRID',
                'type' => 'string',
                'description' => 'Judul utama aplikasi simulator'
            ],
            [
                'key' => 'app_subtitle',
                'value' => 'Panduan interaktif memahami sistem penggerak ramah lingkungan.',
                'type' => 'string',
                'description' => 'Sub judul penjelasan simulator'
            ],
            [
                'key' => 'upload_password',
                'value' => 'Dms1234',
                'type' => 'string',
                'description' => 'Password proteksi untuk upload model 3D baru'
            ],
            [
                'key' => 'default_body_color',
                'value' => 'blue',
                'type' => 'string',
                'description' => 'Warna bawaan bodi (red, white, blue)'
            ],
            [
                'key' => 'default_body_opacity',
                'value' => '0.50',
                'type' => 'float',
                'description' => 'Tingkat transparansi bodi bawaan (0.00 - 1.00)'
            ],
            [
                'key' => 'enable_audio',
                'value' => 'true',
                'type' => 'boolean',
                'description' => 'Mengaktifkan efek suara sistem dan mesin'
            ],
            [
                'key' => 'enable_logging',
                'value' => 'true',
                'type' => 'boolean',
                'description' => 'Mencatat aktivitas interaksi simulasi pengguna'
            ],
            [
                'key' => 'max_speed_dial',
                'value' => '180',
                'type' => 'integer',
                'description' => 'Batas maksimal pembacaan speedometer (km/h)'
            ]
        ];

        foreach ($settings as $item) {
            Setting::updateOrCreate(['key' => $item['key']], $item);
        }
    }
}

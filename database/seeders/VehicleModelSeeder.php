<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\VehicleModel;

class VehicleModelSeeder extends Seeder
{
    public function run(): void
    {
        VehicleModel::updateOrCreate(
            ['file_name' => 'Veloz.glb'],
            [
                'name' => 'Toyota Veloz Hybrid 3D',
                'file_path' => 'models/Veloz.glb',
                'mime_type' => 'model/gltf-binary',
                'file_size' => 5410884,
                'is_active' => true,
                'default_color' => 'blue',
                'default_opacity' => 0.50,
                'meta_data' => [
                    'author' => 'Hybrid Simulator Team',
                    'version' => '2.0',
                    'has_xray' => true,
                    'scale' => 31.0,
                    'position_offset' => [
                        'engine' => [-12.2, -1.6, 0],
                        'mg2' => [-5.2, -3.0, 0],
                        'battery' => [1.8, -3.15, 0],
                    ]
                ]
            ]
        );
    }
}

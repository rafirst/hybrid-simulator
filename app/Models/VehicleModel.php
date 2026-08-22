<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleModel extends Model
{
    use HasFactory;

    protected $table = 'vehicle_models';

    protected $fillable = [
        'name',
        'file_name',
        'file_path',
        'mime_type',
        'file_size',
        'is_active',
        'default_color',
        'default_opacity',
        'meta_data'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'default_opacity' => 'float',
        'meta_data' => 'array',
    ];
}

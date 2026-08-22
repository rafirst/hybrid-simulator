<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SimulationLog extends Model
{
    use HasFactory;

    protected $table = 'simulation_logs';

    protected $fillable = [
        'session_id',
        'action_type',
        'mode',
        'gear',
        'speed',
        'engine_active',
        'mg2_active',
        'battery_active',
        'ip_address',
        'user_agent'
    ];

    protected $casts = [
        'speed' => 'integer',
        'engine_active' => 'boolean',
        'mg2_active' => 'boolean',
        'battery_active' => 'boolean',
    ];
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SimulationLog;
use App\Models\Setting;

class SimulationLogController extends Controller
{
    public function store(Request $request)
    {
        if (!Setting::getVal('enable_logging', true)) {
            return response()->json(['status' => 'disabled']);
        }

        $log = SimulationLog::create([
            'session_id' => $request->input('session_id', session()->getId()),
            'action_type' => $request->input('action_type', 'action'),
            'mode' => $request->input('mode'),
            'gear' => $request->input('gear'),
            'speed' => $request->input('speed', 0),
            'engine_active' => (bool)$request->input('engine_active', false),
            'mg2_active' => (bool)$request->input('mg2_active', false),
            'battery_active' => (bool)$request->input('battery_active', false),
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return response()->json([
            'status' => 'logged',
            'id' => $log->id
        ]);
    }
}

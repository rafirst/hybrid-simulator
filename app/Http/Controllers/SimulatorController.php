<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VehicleModel;
use App\Models\Setting;
use App\Models\SimulationLog;

class SimulatorController extends Controller
{
    public function index()
    {
        // Ambil konfigurasi dan model mobil aktif
        $appTitle = Setting::getVal('app_title', 'CARA KERJA MESIN HYBRID');
        $appSubtitle = Setting::getVal('app_subtitle', 'Panduan interaktif memahami sistem penggerak ramah lingkungan.');
        $activeModel = VehicleModel::where('is_active', true)->latest()->first();

        // Data mode simulasi hybrid lengkap
        $modes = [
            'Idle' => [
                'id' => 'Idle',
                'name' => 'START / IDLE',
                'desc' => 'Mobil mulai dihidupkan',
                'speed' => 0,
                'engine' => false,
                'mg2' => false,
                'battery' => true,
                'flows' => [],
                'detail_html' => 'Mesin bensin mati untuk menghemat bahan bakar.<br><br>Sistem <span class="highlight-text">READY</span> untuk dijalankan. Seluruh sistem kelistrikan bersiaga penuh menanti instruksi pengemudi.',
            ],
            'Low' => [
                'id' => 'Low',
                'name' => 'LOW SPEED',
                'desc' => 'Jalan pelan<br>menggunakan motor listrik',
                'speed' => 20,
                'engine' => false,
                'mg2' => true,
                'battery' => true,
                'flows' => ['cableBattMotor', 'flowMgWheel', 'miniFlowBatt', 'miniFlowMotor'],
                'detail_html' => 'Digerakkan sepenuhnya oleh listrik. Baterai HEV menyalurkan daya tegangan tinggi ke Motor (MG2) yang langsung memutar roda.<br><span class="highlight-text">Tanpa bahan bakar, tanpa emisi, ekstra halus dan senyap.</span><br>Catatan: Berlaku jika daya Baterai HEV > 40%.',
            ],
            'Acceleration' => [
                'id' => 'Acceleration',
                'name' => 'ACCELERATION',
                'desc' => 'Akselerasi<br>mesin dan motor bekerja bersama',
                'speed' => 65,
                'engine' => true,
                'mg2' => true,
                'battery' => true,
                'flows' => ['cableBattMotor', 'flowMgWheel', 'flowEngWheel', 'miniFlowBatt', 'miniFlowMotor', 'miniFlowEng'],
                'detail_html' => 'Kombinasi dorongan tenaga maksimal dari <span class="highlight-text">Mesin Bensin</span> dan sokongan <span class="highlight-text">Baterai Listrik</span> (melalui Motor MG2) bekerja secara bersamaan.<br><br>Memberikan torsi akselerasi instan yang kuat dan responsif seketika.',
            ],
            'Constant' => [
                'id' => 'Constant',
                'name' => 'CONSTANT SPEED',
                'desc' => 'Kecepatan stabil<br>dan efisien',
                'speed' => 80,
                'engine' => true,
                'mg2' => false,
                'battery' => true,
                'flows' => ['flowEngWheel', 'flowEngMg2Charge', 'cableBattMotorRev', 'miniFlowEng', 'miniFlowEngGen', 'miniFlowCharge'],
                'detail_html' => 'Mobil melaju stabil, <span class="highlight-mech">utamanya digerakkan oleh Mesin Bensin pada putaran paling efisien</span>.<br><br>Sebagian kecil tenaga dari putaran roda dan mesin dialihkan untuk memutar Generator (MG1) guna <span class="highlight-text">mengisi ulang daya Baterai</span> secara otomatis tanpa perlu colok listrik.',
            ],
            'Deceleration' => [
                'id' => 'Deceleration',
                'name' => 'DECELERATION',
                'desc' => 'Pengereman<br>mengisi daya baterai',
                'speed' => 45,
                'engine' => false,
                'mg2' => true,
                'battery' => true,
                'flows' => ['flowWheelMg', 'cableBattMotorRev', 'miniFlowCharge', 'miniFlowWheelMg'],
                'detail_html' => 'Sistem memutus bahan bakar. Mesin Bensin otomatis dimatikan.<br><br>Energi kinetik mobil saat mengerem dimanfaatkan kembali oleh Motor Listrik (MG2) yang berubah menjadi generator untuk <span class="highlight-text">menghasilkan listrik & mengisi Baterai</span> secara gratis (Regenerative Braking).',
            ],
            'Reverse' => [
                'id' => 'Reverse',
                'name' => 'REVERSE',
                'desc' => 'Gigi mundur<br>menggunakan motor listrik',
                'speed' => 15,
                'engine' => false,
                'mg2' => true,
                'battery' => true,
                'flows' => ['cableBattMotor', 'flowMgWheel', 'miniFlowBatt', 'miniFlowMotor'],
                'detail_html' => 'Kendaraan bergerak mundur sepenuhnya digerakkan oleh tenaga putaran terbalik dari <span class="highlight-text">Motor Listrik (MG2)</span>.<br><br>Mesin bensin dibiarkan tetap mati, membuat proses parkir atau mundur menjadi sangat presisi, halus, dan hening.',
            ],
        ];

        return view('simulator.index', compact('appTitle', 'appSubtitle', 'activeModel', 'modes'));
    }
}

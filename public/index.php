<?php

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

/*
|--------------------------------------------------------------------------
| Check If The Application Is Under Maintenance
|--------------------------------------------------------------------------
*/

if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

/*
|--------------------------------------------------------------------------
| Register The Auto Loader & Bootstrap
|--------------------------------------------------------------------------
*/

if (file_exists(__DIR__.'/../vendor/autoload.php')) {
    require __DIR__.'/../vendor/autoload.php';
    $app = require_once __DIR__.'/../bootstrap/app.php';

    $kernel = $app->make(Kernel::class);

    $response = $kernel->handle(
        $request = Request::capture()
    )->send();

    $kernel->terminate($request, $response);
} else {
    // Standalone direct preview mode if composer vendor hasn't been installed yet
    header('Content-Type: text/html; charset=utf-8');
    ?>
    <!DOCTYPE html>
    <html lang="id">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>TAG - Alur Kerja Hybrid</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Rajdhani:wght@500;600;700&family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/three@0.128.0/examples/js/controls/OrbitControls.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/three@0.128.0/examples/js/loaders/GLTFLoader.js"></script>
        <link rel="stylesheet" href="css/simulator.css">
    </head>
    <body>
        <div class="app-wrapper" id="appWrapper">
            <!-- Left & Right Branding Logos -->
            <div class="logo-left-box">
                <img class="logo-left-image" src="images/Logo-Toyota-ori.png" alt="Toyota">
            </div>

            <div class="logo-right-box">
                <img class="logo-right-image" src="images/Logo-TAG-ori.png" alt="TAG">
            </div>

            <!-- Top Header Title -->
            <div class="top-header">
                <h1>CARA KERJA MESIN HYBRID</h1>
                <p>Panduan interaktif memahami sistem penggerak ramah lingkungan.</p>
            </div>

            <!-- Main Cockpit -->
            <div class="main-content">
                <!-- Left Column: Mode Selector -->
                <div class="left-col">
                    <div class="left-title">PILIH MODE</div>
                    <div class="mode-btn disabled" id="btn-Idle" data-mode="Idle">
                        <div class="mode-icon-wrapper"><svg viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg></div>
                        <div class="mode-text"><span class="mode-text-title">START / IDLE</span><span class="mode-text-desc">Mobil mulai dihidupkan</span></div>
                    </div>
                    <div class="mode-btn disabled" id="btn-Low" data-mode="Low">
                        <div class="mode-icon-wrapper"><svg viewBox="0 0 24 24"><path d="M17 8C8 10 5.9 16.17 3.82 21.34l1.89.66l.95-2.3c.48.17.96.3 1.34.3C17 20 22 3 22 3c-1 2-8 2.25-13 3.25S2 11.5 2 13.5s1.75 3.75 1.75 3.75C7 8 17 8 17 8z"/></svg></div>
                        <div class="mode-text"><span class="mode-text-title">LOW SPEED</span><span class="mode-text-desc">Jalan pelan<br>menggunakan motor listrik</span></div>
                    </div>
                    <div class="mode-btn disabled" id="btn-Accel" data-mode="Acceleration">
                        <div class="mode-icon-wrapper"><svg viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm5 11h-4v-4c0-.55-.45-1-1-1s-1 .45-1 1v5c0 .55.45 1 1 1h5c.55 0 1-.45 1-1s-.45-1-1-1z"/></svg></div>
                        <div class="mode-text"><span class="mode-text-title">ACCELERATION</span><span class="mode-text-desc">Akselerasi<br>mesin dan motor bekerja bersama</span></div>
                    </div>
                    <div class="mode-btn disabled" id="btn-Const" data-mode="Constant">
                        <div class="mode-icon-wrapper"><svg viewBox="0 0 24 24"><path d="M12 4c-4.42 0-8 3.58-8 8s3.58 8 8 8 8-3.58 8-8-3.58-8-8-8zm0 14c-3.31 0-6-2.69-6-6s2.69-6 6-6 6 2.69 6 6-2.69 6-6 6zm1-6h4c.55 0 1-.45 1-1s-.45-1-1-1h-4c-.55 0-1 .45-1 1s.45 1 1 1z"/></svg></div>
                        <div class="mode-text"><span class="mode-text-title">CONSTANT SPEED</span><span class="mode-text-desc">Kecepatan stabil<br>dan efisien</span></div>
                    </div>
                    <div class="mode-btn disabled" id="btn-Decel" data-mode="Deceleration">
                        <div class="mode-icon-wrapper"><svg viewBox="0 0 24 24"><path d="M16 4h-2V2h-4v2H8c-.55 0-1 .45-1 1v16c0 .55.45 1 1 1h8c.55 0 1-.45 1-1V5c0-.55-.45-1-1-1zm-4 14l-2.5-4h2v-4h1v4h2L12 18z"/></svg></div>
                        <div class="mode-text"><span class="mode-text-title">DECELERATION</span><span class="mode-text-desc">Pengereman<br>mengisi daya baterai</span></div>
                    </div>
                    <div class="mode-btn disabled" id="btn-Rev" data-mode="Reverse">
                        <div class="mode-icon-wrapper"><span style="font-size: 38px; font-weight: 900; color: var(--color-blue);">R</span></div>
                        <div class="mode-text"><span class="mode-text-title">REVERSE</span><span class="mode-text-desc">Gigi mundur<br>menggunakan motor listrik</span></div>
                    </div>
                    <div class="bottom-bar">
                        <div class="console-dock">
                            <button class="gear-btn btn-power" id="btnPower" title="Power">
                                <svg viewBox="0 0 24 24"><path d="M18.36 6.64a9 9 0 1 1-12.73 0"></path><line x1="12" y1="2" x2="12" y2="12"></line></svg>
                            </button>
                            <button class="gear-btn gear-shift-btn disabled" id="gearD" title="Drive"><span class="gear-letter">D</span></button>
                            <button class="gear-btn gear-shift-btn disabled" id="gearR" title="Reverse"><span class="gear-letter">R</span></button>
                        </div>
                    </div>
                </div>

                <!-- Center Column: 3D Display -->
                <div class="center-col">
                    <div class="panel car-main-display" id="panelCarCenter">
                        <div class="active-mode-label">
                            <h3>MODE AKTIF:</h3>
                            <h2 id="displayModeTitle">MATI</h2>
                        </div>
                        <div class="big-car-container" id="car3dContainer">
                            <div class="model-loading" id="modelLoading">SISTEM 3D SIAP</div>
                            <div class="label-3d" id="lbl3dEngine">ENGINE<span class="lbl-off" id="st3dEngine">(MATI)</span></div>
                            <div class="label-3d" id="lbl3dMg2">MOTOR LISTRIK (MG2)<span class="lbl-off" id="st3dMg2">(MATI)</span></div>
                            <div class="label-3d" id="lbl3dBattery">BATERAI<span class="lbl-off" id="st3dBattery">(MATI)</span></div>
                        </div>
                        <div class="customize-wrap">
                            <button class="customize-btn" id="btnCustomize">CUSTOMIZE</button>
                            <div class="customize-panel" id="customizePanel">
                                <div class="customize-title">
                                    <span>3D VEHICLE VIEW<br>VISUALIZATION CONTROL</span>
                                </div>
                                <div class="customize-group">
                                    <div class="customize-label">Warna:</div>
                                    <div class="swatch-row" id="bodyColorControls">
                                        <button class="swatch-btn active" data-color="white" aria-label="Putih" title="Platinum White Pearl"></button>
                                    </div>
                                </div>
                                <div class="customize-group">
                                    <div class="customize-label">Opacity:</div>
                                    <div class="opacity-row" id="bodyOpacityControls">
                                        <label class="toggle-switch" title="ON: 50% X-Ray, OFF: 0% Rangka">
                                            <input type="checkbox" id="bodyOpacityToggle" checked>
                                            <span class="toggle-slider"></span>
                                            <span class="toggle-state" aria-hidden="true">ON</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="upload-status" id="uploadStatus">MOBIL: VELOZ HYBRID</div>
                            </div>
                        </div>
                        <div class="center-legend">
                            <div class="leg-item leg-elec"><div class="arrow-line"></div><span>Aliran Energi Listrik</span></div>
                            <div class="leg-item leg-mech"><div class="arrow-line"></div><span>Aliran Energi Mekanis</span></div>
                            <div class="leg-item leg-off"><div class="dot"></div><span>Kabel Statis</span></div>
                        </div>
                    </div>

                    <div class="info-bottom-row dimmed" id="panelInfoCenter">
                        <div class="panel info-box">
                            <div class="box-title">PENJELASAN MODE</div>
                            <div class="penjelasan-content">
                                <div class="penjelasan-icon" id="descIcon">
                                    <svg viewBox="0 0 24 24"><path d="M17 8C8 10 5.9 16.17 3.82 21.34l1.89.66l.95-2.3c.48.17.96.3 1.34.3C17 20 22 3 22 3c-1 2-8 2.25-13 3.25S2 11.5 2 13.5s1.75 3.75 1.75 3.75C7 8 17 8 17 8z"/></svg>
                                </div>
                                <div class="penjelasan-text-area">
                                    <div class="penjelasan-title" id="descTitle">-</div>
                                    <div class="penjelasan-desc" id="descText">Sistem dalam keadaan mati. Tekan tombol POWER di sudut kiri bawah untuk menyalakan simulasi mobil.</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="right-col">
                    <!-- Speedometer -->
                    <div class="panel panel-speedo dimmed" id="panelSpeedo">
                        <h3>SPEEDOMETER</h3>
                        <div class="speed-svg-wrapper">
                            <svg width="100%" height="100%" viewBox="0 0 350 180">
                                <path d="M 30 160 A 145 145 0 0 1 320 160" fill="none" stroke="#1e3a5f" stroke-width="12" stroke-linecap="round"/>
                                <path d="M 30 160 A 145 145 0 0 1 320 160" fill="none" stroke="#dc2626" stroke-width="12" stroke-linecap="butt" stroke-dasharray="0 253.1 300"/>
                                <defs>
                                    <linearGradient id="speedGrad" x1="0%" y1="0%" x2="100%" y2="0%">
                                        <stop offset="0%" stop-color="#0ea5e9" /><stop offset="58.7%" stop-color="#0ea5e9" />
                                        <stop offset="58.7%" stop-color="#ef4444" /><stop offset="100%" stop-color="#ef4444" />
                                    </linearGradient>
                                </defs>
                                <path id="speedArcFill" d="M 30 160 A 145 145 0 0 1 320 160" fill="none" stroke="url(#speedGrad)" stroke-width="12" stroke-linecap="round" stroke-dasharray="455.5" stroke-dashoffset="455.5" style="transition: stroke-dashoffset 0.1s linear;"/>
                                <path d="M 15 160 A 160 160 0 0 1 335 160" fill="none" stroke="#ffffff" stroke-width="6" stroke-dasharray="2 22.3" stroke-linecap="butt"/>
                                <g fill="white" font-size="14" font-weight="normal" text-anchor="middle" dominant-baseline="central">
                                    <text x="60" y="155">0</text><text x="67" y="121">20</text><text x="87" y="86">40</text>
                                    <text x="117" y="60">60</text><text x="155" y="47">80</text><text x="195" y="47" fill="#ef4444">100</text>
                                    <text x="233" y="60" fill="#ef4444">120</text><text x="263" y="86" fill="#ef4444">140</text>
                                    <text x="283" y="121" fill="#ef4444">160</text><text x="290" y="155" fill="#ef4444">180</text>
                                </g>
                                <g id="speedNeedle" style="transform-origin: 175px 160px; transform: rotate(-90deg); transition: transform 0.1s linear;">
                                    <polygon points="170,165 180,165 175,25" fill="#ffffff" filter="drop-shadow(0 0 5px rgba(255,255,255,0.8))"/>
                                </g>
                                <circle cx="175" cy="160" r="10" fill="#0ea5e9"/>
                            </svg>
                            <div class="speed-center-text">
                                <div class="speed-val" id="speedValue">0</div>
                                <div class="speed-unit">km/h</div>
                            </div>
                        </div>
                    </div>

                    <!-- Energy Monitor -->
                    <div class="panel panel-energy dimmed" id="panelEnergyMini">
                        <h3>ENERGY MONITOR</h3>
                        <div class="energy-svg-wrapper">
                            <svg width="100%" height="100%" viewBox="0 0 350 150" preserveAspectRatio="xMidYMid meet">
                                <rect x="25" y="20" width="300" height="110" rx="30" fill="rgba(255,255,255,0.03)" stroke="#1e3a5f" stroke-width="2"/>
                                <rect x="60" y="10" width="40" height="15" rx="5" fill="#000" stroke="#475569"/>
                                <rect x="60" y="125" width="40" height="15" rx="5" fill="#000" stroke="#475569"/>
                                <rect x="250" y="10" width="40" height="15" rx="5" fill="#000" stroke="#475569"/>
                                <rect x="250" y="125" width="40" height="15" rx="5" fill="#000" stroke="#475569"/>
                                <line x1="80" y1="25" x2="80" y2="125" stroke="#475569" stroke-width="4"/>
                                <line x1="270" y1="25" x2="270" y2="125" stroke="#475569" stroke-width="4"/>
                                <line x1="80" y1="75" x2="230" y2="75" stroke="#475569" stroke-width="4"/>
                                <path id="miniFlowBatt" class="arrow-flow flow-elec" d="M 230,75 L 140,75" style="display:none;"/>
                                <path id="miniFlowMotor" class="arrow-flow flow-elec" d="M 120,75 L 80,75 M 80,75 L 80,30 M 80,75 L 80,120" style="display:none;"/>
                                <path id="miniFlowWheelMg" class="arrow-flow flow-elec" d="M 80,30 L 80,75 M 80,120 L 80,75 M 80,75 L 120,75" style="display:none;"/>
                                <path id="miniFlowEng" class="arrow-flow flow-mech" d="M 50,75 L 80,75 M 80,75 L 80,30 M 80,75 L 80,120" style="display:none;"/>
                                <path id="miniFlowEngGen" class="arrow-flow flow-mech" d="M 65,75 L 120,75" style="display:none;"/>
                                <path id="miniFlowCharge" class="arrow-flow flow-elec" d="M 145,75 L 230,75" style="display:none;"/>
                                <rect id="miniEngBox" x="35" y="55" width="30" height="40" fill="#475569" rx="3"/>
                                <rect id="miniMg2Box" x="120" y="60" width="25" height="30" fill="#475569" rx="4"/>
                                <rect id="miniBattBox" x="230" y="40" width="50" height="70" fill="none" stroke="#475569" stroke-width="2" rx="4"/>
                                <rect x="235" y="45" width="10" height="60" fill="#475569" class="mini-batt-cell"/>
                                <rect x="250" y="45" width="10" height="60" fill="#475569" class="mini-batt-cell"/>
                                <rect x="265" y="45" width="10" height="60" fill="#475569" class="mini-batt-cell"/>
                            </svg>
                        </div>
                        <div class="right-legend">
                            <div class="r-leg-item"><div class="r-dot" style="background: var(--color-electric);"></div><span>Aliran Listrik</span></div>
                            <div class="r-leg-item"><div class="r-dot" style="background: var(--color-mechanic);"></div><span>Aliran Mekanis</span></div>
                            <div class="r-leg-item"><div class="r-dot" style="background: var(--color-off);"></div><span>Tidak Aktif</span></div>
                        </div>
                    </div>

                    <!-- Component Status -->
                    <div class="panel panel-kondisi dimmed" id="panelKondisi">
                        <h3>KONDISI KOMPONEN</h3>
                        <div class="kondisi-list">
                            <div class="kondisi-item">
                                <div class="kondisi-name" id="nameEngine">
                                    <div class="kondisi-icon" id="iconEngine"><svg viewBox="0 0 24 24"><path d="M12 2C8.69 2 6 4.69 6 8v3.5L3.5 15h17L18 11.5V8c0-3.31-2.69-6-6-6zm-1 12H9v-2h2v2zm4 0h-2v-2h2v2zm0-4H9V8h6v2z"/></svg></div>
                                    Mesin Bensin
                                </div>
                                <span class="kondisi-stat txt-red" id="statEngine">Mati</span>
                            </div>
                            <div class="kondisi-item">
                                <div class="kondisi-name" id="nameMg2">
                                    <div class="kondisi-icon" id="iconMg2"><svg viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/></svg></div>
                                    Motor Listrik (MG2)
                                </div>
                                <span class="kondisi-stat txt-green" id="statMg2">Mati</span>
                            </div>
                            <div class="kondisi-item border-none">
                                <div class="kondisi-name" id="nameBattery">
                                    <div class="kondisi-icon" id="iconBattery"><svg viewBox="0 0 24 24"><path d="M16 4h-2V2h-4v2H8c-.55 0-1 .45-1 1v16c0 .55.45 1 1 1h8c.55 0 1-.45 1-1V5c0-.55-.45-1-1-1zm-4 14l-2.5-4h2v-4h1v4h2L12 18z"/></svg></div>
                                    Baterai
                                </div>
                                <span class="kondisi-stat txt-green" id="statBattery">Mati</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <script src="js/simulator-3d.js"></script>
        <script src="js/simulator-core.js"></script>
    </body>
    </html>
    <?php
}

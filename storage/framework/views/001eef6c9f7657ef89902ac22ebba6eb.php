<div class="panel car-main-display" id="panelCarCenter">
    
    <div class="active-mode-label">
        <div class="mode-label-header">
            <span class="mode-pulse-dot"></span>
            <span class="mode-header-text">MODE AKTIF SIMULATOR</span>
        </div>
        <h2 id="displayModeTitle" class="mode-title-glow">MATI</h2>
    </div>

    
    <div class="center-legend">
        <div class="leg-item leg-elec">
            <span class="flow-pill-indicator elec-glow"></span>
            <span>Aliran Listrik (Electric)</span>
        </div>
        <div class="leg-item leg-mech">
            <span class="flow-pill-indicator mech-glow"></span>
            <span>Aliran Mekanis (Gasoline)</span>
        </div>
        <div class="leg-item leg-off">
            <span class="flow-pill-indicator off-glow"></span>
            <span>Standby / Off</span>
        </div>
    </div>

    
    <div class="big-car-container" id="car3dContainer">
        <div class="model-loading" id="modelLoading">SISTEM 3D SIAP</div>

        
        <div class="label-3d" id="lbl3dEngine">
            <div class="lbl-icon-pin"></div>
            <div class="lbl-text-wrap">
                <span class="lbl-title">ENGINE</span>
                <span class="lbl-off" id="st3dEngine">(MATI)</span>
            </div>
        </div>
        <div class="label-3d" id="lbl3dMg2">
            <div class="lbl-icon-pin"></div>
            <div class="lbl-text-wrap">
                <span class="lbl-title">MOTOR LISTRIK (MG2)</span>
                <span class="lbl-off" id="st3dMg2">(MATI)</span>
            </div>
        </div>
        <div class="label-3d" id="lbl3dBattery">
            <div class="lbl-icon-pin"></div>
            <div class="lbl-text-wrap">
                <span class="lbl-title">BATERAI HEV</span>
                <span class="lbl-off" id="st3dBattery">(MATI)</span>
            </div>
        </div>
    </div>

    
    <div class="customize-wrap">
        <button class="customize-btn" id="btnCustomize">CUSTOMIZE</button>
        <div class="customize-panel" id="customizePanel">
            <div class="customize-title">
                <div class="cust-title-text">
                    <span class="cust-primary">3D VEHICLE VIEW</span>
                    <span class="cust-sub">VISUALIZATION CONTROL</span>
                </div>
            </div>

            <div class="customize-divider"></div>

            <div class="customize-group">
                <div class="customize-label">WARNA BODY:</div>
                <div class="swatch-row" id="bodyColorControls">
                    <button class="swatch-btn active" data-color="white" aria-label="Putih" title="Platinum White Pearl"></button>
                </div>
            </div>

            <div class="customize-divider"></div>

            <div class="customize-group">
                <div class="customize-label">TRANSPARANSI:</div>
                <div class="opacity-row" id="bodyOpacityControls">
                    <label class="toggle-switch" title="ON: 50% X-Ray, OFF: 0% Rangka">
                        <input type="checkbox" id="bodyOpacityToggle" checked>
                        <span class="toggle-slider"></span>
                        <span class="toggle-state" aria-hidden="true">ON</span>
                    </label>
                </div>
            </div>

            <div class="customize-divider"></div>

            <div class="upload-status-box">
                <div class="upload-status-dot"></div>
                <div class="upload-status" id="uploadStatus">MOBIL: VELOZ HYBRID</div>
            </div>
            <div class="customize-note">Seluruh bodi model ikut berubah, termasuk kaca X-Ray mode.</div>
        </div>
    </div>
</div>
<?php /**PATH C:\laragon\www\hybrid-simulator-git\resources\views\simulator\partials\car_display.blade.php ENDPATH**/ ?>
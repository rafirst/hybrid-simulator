<div class="panel car-main-display" id="panelCarCenter">
    
    <div class="active-mode-label">
        <h3>MODE AKTIF:</h3>
        <h2 id="displayModeTitle">MATI</h2>
    </div>

    
    <div class="big-car-container" id="car3dContainer">
        <div class="model-loading" id="modelLoading">SISTEM 3D SIAP</div>

        
        <div class="label-3d" id="lbl3dEngine">
            ENGINE
            <span class="lbl-off" id="st3dEngine">(MATI)</span>
        </div>
        <div class="label-3d" id="lbl3dMg2">
            MOTOR LISTRIK (MG2)
            <span class="lbl-off" id="st3dMg2">(MATI)</span>
        </div>
        <div class="label-3d" id="lbl3dBattery">
            BATERAI
            <span class="lbl-off" id="st3dBattery">(MATI)</span>
        </div>
    </div>

    
    <div class="customize-wrap">
        <button class="customize-btn" id="btnCustomize">CUSTOMIZE</button>
        <div class="customize-panel" id="customizePanel">
            <div class="customize-title">
                <span>CUSTOMIZE<br>BODY</span>
                <button class="upload-model-btn" id="btnUploadModel" title="Upload model 3D .glb / .gltf">
                    <svg viewBox="0 0 24 24">
                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                        <path d="M17 8l-5-5-5 5"></path>
                        <path d="M12 3v12"></path>
                    </svg>
                </button>
                <input class="model-file-input" id="modelFileInput" type="file" accept=".glb,.gltf,model/gltf-binary,model/gltf+json">
            </div>
            <div class="customize-group">
                <div class="customize-label">Warna:</div>
                <div class="swatch-row" id="bodyColorControls">
                    <button class="swatch-btn" data-color="red" aria-label="Merah"></button>
                    <button class="swatch-btn" data-color="white" aria-label="Putih"></button>
                    <button class="swatch-btn active" data-color="blue" aria-label="Biru"></button>
                </div>
            </div>
            <div class="customize-group">
                <div class="customize-label">Opacity:</div>
                <div class="opacity-row" id="bodyOpacityControls">
                    <button class="opacity-btn active" data-opacity="0.5">50%</button>
                    <button class="opacity-btn" data-opacity="0.2">20%</button>
                    <button class="opacity-btn" data-opacity="0">0%</button>
                </div>
            </div>
            <div class="upload-status" id="uploadStatus">Model hybrid 3D siap disimulasikan.</div>
            <div class="customize-note">Seluruh bodi model ikut berubah, termasuk kaca X-Ray mode.</div>
        </div>
    </div>

    
    <div class="center-legend">
        <div class="leg-item leg-elec">
            <div class="arrow-line"></div>
            <span>Aliran Energi Listrik</span>
        </div>
        <div class="leg-item leg-mech">
            <div class="arrow-line"></div>
            <span>Aliran Energi Mekanis</span>
        </div>
        <div class="leg-item leg-off">
            <div class="dot"></div>
            <span>Kabel Statis (Tidak Aktif)</span>
        </div>
    </div>
</div>
<?php /**PATH C:\laragon\www\hybrid-simulator-laravel\resources\views\simulator\partials\car_display.blade.php ENDPATH**/ ?>
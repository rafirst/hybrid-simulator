<div class="panel panel-kondisi dimmed" id="panelKondisi">
    <div class="panel-header-row">
        <div class="panel-tag">HARDWARE TELEMETRY</div>
        <h3>STATUS KOMPONEN UTAMA</h3>
    </div>

    <div class="kondisi-list">
        
        <div class="kondisi-item">
            <div class="kondisi-name" id="nameEngine">
                <div class="kondisi-icon" id="iconEngine">
                    <svg viewBox="0 0 24 24"><path d="M7 4V2h10v2h2a2 2 0 0 1 2 2v3h-2V6H5v3H3V6a2 2 0 0 1 2-2h2zm13 7v7a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2v-7h16zm-8 2h-4v3h4v-3zm6 0h-4v3h4v-3z"/></svg>
                </div>
                <div class="kondisi-meta">
                    <span class="komponen-title">Mesin Bensin (ICE)</span>
                    <span class="komponen-spec">1.5L DOHC Dual VVT-i</span>
                </div>
            </div>
            <div class="stat-pill-wrap">
                <span class="kondisi-stat txt-red" id="statEngine">Mati</span>
            </div>
        </div>

        
        <div class="kondisi-item">
            <div class="kondisi-name" id="nameMg2">
                <div class="kondisi-icon" id="iconMg2">
                    <svg viewBox="0 0 24 24"><path d="M12 2a10 10 0 1 0 10 10A10 10 0 0 0 12 2zm0 18a8 8 0 1 1 8-8 8 8 0 0 1-8 8zm1-13h-2v4H7v2h4v4h2v-4h4v-2h-4z"/></svg>
                </div>
                <div class="kondisi-meta">
                    <span class="komponen-title">Motor Listrik (MG2)</span>
                    <span class="komponen-spec">Permanent Magnet Synchronous</span>
                </div>
            </div>
            <div class="stat-pill-wrap">
                <span class="kondisi-stat txt-green" id="statMg2">Mati</span>
            </div>
        </div>

        
        <div class="kondisi-item border-none">
            <div class="kondisi-name" id="nameBattery">
                <div class="kondisi-icon" id="iconBattery">
                    <svg viewBox="0 0 24 24"><path d="M16 4h-2V2h-4v2H8a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2zm-3 14l-4-5h3V9l4 5h-3v4z"/></svg>
                </div>
                <div class="kondisi-meta">
                    <span class="komponen-title">Baterai Traksi (HEV)</span>
                    <span class="komponen-spec">Lithium-ion High Voltage</span>
                </div>
            </div>
            <div class="stat-pill-wrap">
                <span class="kondisi-stat txt-green" id="statBattery">Mati</span>
            </div>
        </div>
    </div>
</div>
<?php /**PATH C:\laragon\www\hybrid-simulator-git\resources\views/simulator/partials/component_status.blade.php ENDPATH**/ ?>
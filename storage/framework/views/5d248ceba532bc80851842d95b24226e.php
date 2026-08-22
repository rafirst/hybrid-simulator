<div class="panel panel-energy dimmed" id="panelEnergyMini">
    <h3>ENERGY MONITOR</h3>
    <div class="energy-svg-wrapper">
        <svg width="100%" height="100%" viewBox="0 0 350 150" preserveAspectRatio="xMidYMid meet">
            <!-- Outer Car Chassis Outline -->
            <rect x="25" y="20" width="300" height="110" rx="30" fill="rgba(255,255,255,0.03)" stroke="#1e3a5f" stroke-width="2"/>
            
            <!-- 4 Wheels -->
            <rect x="60" y="10" width="40" height="15" rx="5" fill="#000" stroke="#475569"/>
            <rect x="60" y="125" width="40" height="15" rx="5" fill="#000" stroke="#475569"/>
            <rect x="250" y="10" width="40" height="15" rx="5" fill="#000" stroke="#475569"/>
            <rect x="250" y="125" width="40" height="15" rx="5" fill="#000" stroke="#475569"/>

            <!-- Static Axles & Drive Lines -->
            <line x1="80" y1="25" x2="80" y2="125" stroke="#475569" stroke-width="4"/>
            <line x1="270" y1="25" x2="270" y2="125" stroke="#475569" stroke-width="4"/>
            <line x1="80" y1="75" x2="230" y2="75" stroke="#475569" stroke-width="4"/>

            <!-- Dynamic Animated Flow Overlays (Electric & Mechanic) -->
            <path id="miniFlowBatt" class="arrow-flow flow-elec" d="M 230,75 L 140,75" style="display:none;"/>
            <path id="miniFlowMotor" class="arrow-flow flow-elec" d="M 120,75 L 80,75 M 80,75 L 80,30 M 80,75 L 80,120" style="display:none;"/>
            <path id="miniFlowWheelMg" class="arrow-flow flow-elec" d="M 80,30 L 80,75 M 80,120 L 80,75 M 80,75 L 120,75" style="display:none;"/>
            <path id="miniFlowEng" class="arrow-flow flow-mech" d="M 50,75 L 80,75 M 80,75 L 80,30 M 80,75 L 80,120" style="display:none;"/>
            <path id="miniFlowEngGen" class="arrow-flow flow-mech" d="M 65,75 L 120,75" style="display:none;"/>
            <path id="miniFlowCharge" class="arrow-flow flow-elec" d="M 145,75 L 230,75" style="display:none;"/>

            <!-- Engine Component Box -->
            <rect id="miniEngBox" x="35" y="55" width="30" height="40" fill="#475569" rx="3"/>
            
            <!-- Motor MG2 Component Box -->
            <rect id="miniMg2Box" x="120" y="60" width="25" height="30" fill="#475569" rx="4"/>
            
            <!-- Battery Component Box & Cells -->
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
<?php /**PATH C:\laragon\www\hybrid-simulator-laravel\resources\views/simulator/partials/energy_monitor.blade.php ENDPATH**/ ?>
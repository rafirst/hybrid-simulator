<div class="panel panel-energy dimmed" id="panelEnergyMini">
    <div class="panel-header-row">
        <div class="panel-tag">POWERTRAIN TELEMETRY</div>
        <h3>ENERGY FLOW MONITOR</h3>
    </div>

    <div class="energy-svg-wrapper">
        <svg width="100%" height="100%" viewBox="0 0 350 150" preserveAspectRatio="xMidYMid meet">
            <defs>
                <pattern id="ecoGrid" width="10" height="10" patternUnits="userSpaceOnUse">
                    <path d="M 10 0 L 0 0 0 10" fill="none" stroke="rgba(239, 68, 68, 0.04)" stroke-width="0.5"/>
                </pattern>
                
                <linearGradient id="chassisGrad" x1="0%" y1="0%" x2="100%" y2="0%">
                    <stop offset="0%" stop-color="rgba(239, 68, 68, 0.14)" />
                    <stop offset="50%" stop-color="rgba(127, 29, 29, 0.08)" />
                    <stop offset="100%" stop-color="rgba(239, 68, 68, 0.14)" />
                </linearGradient>

            </defs>

            <!-- Blueprint Background Grid -->
            <rect x="15" y="5" width="320" height="140" fill="url(#ecoGrid)" rx="16"/>

            <!-- Futuristic Aerodynamic Vehicle Chassis Silhouette -->
            <path d="M 30,75 Q 30,30 65,22 L 240,22 Q 295,24 315,55 Q 325,75 315,95 Q 295,126 240,128 L 65,128 Q 30,120 30,75 Z" 
                  fill="url(#chassisGrad)" stroke="#7f1d1d" stroke-width="1.8" stroke-dasharray="8 4"/>
            
            <!-- Structural Centerline & High Voltage Conduit Tunnel -->
            <line x1="45" y1="75" x2="300" y2="75" stroke="rgba(248, 113, 113, 0.2)" stroke-width="1.5" stroke-dasharray="3 3"/>

            <!-- 4 Modern Wheels with Alloy Hubs -->
            <!-- Front Wheels (Left) -->
            <g class="wheel-group">
                <rect x="58" y="8" width="44" height="18" rx="4" fill="#210707" stroke="#7f1d1d" stroke-width="1.5"/>
                <line x1="64" y1="17" x2="96" y2="17" stroke="#00E676" stroke-width="2" opacity="0.8"/>
                <rect x="58" y="124" width="44" height="18" rx="4" fill="#210707" stroke="#7f1d1d" stroke-width="1.5"/>
                <line x1="64" y1="133" x2="96" y2="133" stroke="#00E676" stroke-width="2" opacity="0.8"/>
            </g>

            <!-- Rear Wheels (Right) -->
            <g class="wheel-group">
                <rect x="248" y="8" width="44" height="18" rx="4" fill="#210707" stroke="#7f1d1d" stroke-width="1.5"/>
                <line x1="254" y1="17" x2="286" y2="17" stroke="#00E676" stroke-width="2" opacity="0.6"/>
                <rect x="248" y="124" width="44" height="18" rx="4" fill="#210707" stroke="#7f1d1d" stroke-width="1.5"/>
                <line x1="254" y1="133" x2="286" y2="133" stroke="#00E676" stroke-width="2" opacity="0.6"/>
            </g>

            <!-- Static Axles & Drive Mechanical Lines -->
            <line x1="80" y1="26" x2="80" y2="124" stroke="#5b1111" stroke-width="3" stroke-linecap="round"/>
            <line x1="270" y1="26" x2="270" y2="124" stroke="#5b1111" stroke-width="3" stroke-linecap="round"/>
            <line x1="80" y1="75" x2="230" y2="75" stroke="#5b1111" stroke-width="3"/>

            <!-- Dynamic Animated Flow Overlays (Electric & Mechanic - Controlled by JS) -->
            <path id="miniFlowBatt" class="arrow-flow flow-elec" d="M 230,75 L 140,75" style="display:none;"/>
            <path id="miniFlowMotor" class="arrow-flow flow-elec" d="M 120,75 L 80,75 M 80,75 L 80,30 M 80,75 L 80,120" style="display:none;"/>
            <path id="miniFlowWheelMg" class="arrow-flow flow-elec" d="M 80,30 L 80,75 M 80,120 L 80,75 M 80,75 L 120,75" style="display:none;"/>
            <path id="miniFlowEng" class="arrow-flow flow-mech" d="M 50,75 L 80,75 M 80,75 L 80,30 M 80,75 L 80,120" style="display:none;"/>
            <path id="miniFlowEngGen" class="arrow-flow flow-mech" d="M 65,75 L 120,75" style="display:none;"/>
            <path id="miniFlowCharge" class="arrow-flow flow-elec" d="M 145,75 L 230,75" style="display:none;"/>

            <!-- 1. Engine Component Box (Gasoline IC Engine) -->
            <rect id="miniEngBox" x="35" y="55" width="30" height="40" rx="6" fill="#475569" stroke="rgba(255,255,255,0.2)" stroke-width="1.5"/>
            <text x="50" y="77" font-size="8" font-family="'Orbitron', sans-serif" font-weight="700" fill="#ffffff" text-anchor="middle" dominant-baseline="central" pointer-events="none">ENG</text>
            
            <!-- 2. Motor MG2 Component Box (Electric Inverter/Motor) -->
            <rect id="miniMg2Box" x="120" y="60" width="25" height="30" rx="6" fill="#475569" stroke="rgba(255,255,255,0.2)" stroke-width="1.5"/>
            <text x="132.5" y="75" font-size="8" font-family="'Orbitron', sans-serif" font-weight="700" fill="#ffffff" text-anchor="middle" dominant-baseline="central" pointer-events="none">MG2</text>
            
            <!-- 3. Battery Component Box & Multi-Cell Modules -->
            <rect id="miniBattBox" x="230" y="40" width="50" height="70" rx="8" fill="rgba(25, 5, 5, 0.9)" stroke="#7f1d1d" stroke-width="2"/>
            <text x="255" y="32" font-size="8" font-family="'Plus Jakarta Sans', sans-serif" font-weight="700" fill="var(--text-muted)" text-anchor="middle">HEV BATT</text>
            <rect x="235" y="45" width="10" height="60" rx="3" fill="#475569" class="mini-batt-cell"/>
            <rect x="250" y="45" width="10" height="60" rx="3" fill="#475569" class="mini-batt-cell"/>
            <rect x="265" y="45" width="10" height="60" rx="3" fill="#475569" class="mini-batt-cell"/>
        </svg>
    </div>

    <!-- Interactive Color Legend -->
    <div class="right-legend">
        <div class="r-leg-item">
            <div class="r-dot dot-elec"></div>
            <span>Aliran Listrik (EV)</span>
        </div>
        <div class="r-leg-item">
            <div class="r-dot dot-mech"></div>
            <span>Aliran Mekanis (Bensin)</span>
        </div>
        <div class="r-leg-item">
            <div class="r-dot dot-off"></div>
            <span>Standby / Off</span>
        </div>
    </div>
</div>

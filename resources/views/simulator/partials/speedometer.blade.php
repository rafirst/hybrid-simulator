<div class="panel panel-speedo dimmed" id="panelSpeedo">
    <div class="panel-header-row">
        <div class="panel-tag">CLUSTER TELEMETRY</div>
        <h3>SPEEDOMETER</h3>
    </div>

    <div class="speed-svg-wrapper">
        <svg width="100%" height="100%" viewBox="0 0 350 180">
            <defs>
                {{-- Neutral dynamic speed gradient --}}
                <linearGradient id="speedGrad" x1="0%" y1="0%" x2="100%" y2="0%">
                    <stop offset="0%" stop-color="#475569" />
                    <stop offset="45%" stop-color="#64748b" />
                    <stop offset="68%" stop-color="#94a3b8" />
                    <stop offset="85%" stop-color="#cbd5e1" />
                    <stop offset="100%" stop-color="#475569" />
                </linearGradient>

            </defs>

            <!-- Background Arc Track Shadow / Glow -->
            <path d="M 30 160 A 145 145 0 0 1 320 160" fill="none" stroke="rgba(239, 68, 68, 0.15)" stroke-width="16" stroke-linecap="round"/>
            <path d="M 30 160 A 145 145 0 0 1 320 160" fill="none" stroke="#2a0808" stroke-width="10" stroke-linecap="round"/>
            
            <!-- Redline Zone Marker -->
            <path d="M 30 160 A 145 145 0 0 1 320 160" fill="none" stroke="#ef4444" stroke-width="10" stroke-linecap="butt" stroke-dasharray="0 253.1 300" opacity="0.4"/>

            <!-- Active Speed Dynamic Arc Fill (Connected to JS) -->
            <path id="speedArcFill" d="M 30 160 A 145 145 0 0 1 320 160" fill="none" stroke="url(#speedGrad)" stroke-width="10" stroke-linecap="round" stroke-dasharray="455.5" stroke-dashoffset="455.5" style="transition: stroke-dashoffset 0.1s linear;"/>
            
            <!-- Outer Fine Tick Marks -->
            <path d="M 15 160 A 160 160 0 0 1 335 160" fill="none" stroke="rgba(255,255,255,0.25)" stroke-width="6" stroke-dasharray="2 22.3" stroke-linecap="butt"/>

            <!-- Speed Numbers (0 to 180 km/h) -->
            <g fill="#111827" font-family="'Orbitron', 'Rajdhani', sans-serif" font-size="12" font-weight="600" text-anchor="middle" dominant-baseline="central">
                <text x="60" y="155">0</text>
                <text x="67" y="121">20</text>
                <text x="87" y="86">40</text>
                <text x="117" y="60">60</text>
                <text x="155" y="47">80</text>
                <text x="195" y="47" fill="#fbbf24">100</text>
                <text x="233" y="60" fill="#f87171">120</text>
                <text x="263" y="86" fill="#ef4444">140</text>
                <text x="283" y="121" fill="#ef4444">160</text>
                <text x="290" y="155" fill="#ef4444">180</text>
            </g>

            <!-- Speedometer Needle (Rotated by JS) -->
            <g id="speedNeedle" style="transform-origin: 175px 160px; transform: rotate(-90deg); transition: transform 0.1s linear;">
                <polygon points="172,165 178,165 175,25" fill="#111827"/>
                <circle cx="175" cy="40" r="2.5" fill="#111827"/>
            </g>
            
            <!-- Center Pivot Ring -->
            <circle cx="175" cy="160" r="14" fill="#170505" stroke="#ef4444" stroke-width="2"/>
            <circle cx="175" cy="160" r="6" fill="#ef4444"/>
        </svg>

        <!-- Digital Center Speed Display -->
        <div class="speed-center-text">
            <div class="speed-val-wrap">
                <span class="speed-val" id="speedValue">0</span>
            </div>
            <div class="speed-unit-wrap">
                <span class="speed-unit">KM/H</span>
                <span class="speed-sub-label">DIGITAL SPEED</span>
            </div>
        </div>
    </div>
</div>

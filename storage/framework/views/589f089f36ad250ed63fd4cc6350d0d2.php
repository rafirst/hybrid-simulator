<div class="panel panel-speedo dimmed" id="panelSpeedo">
    <h3>SPEEDOMETER</h3>
    <div class="speed-svg-wrapper">
        <svg width="100%" height="100%" viewBox="0 0 350 180">
            <!-- Background Arc Track -->
            <path d="M 30 160 A 145 145 0 0 1 320 160" fill="none" stroke="#1e3a5f" stroke-width="12" stroke-linecap="round"/>
            <path d="M 30 160 A 145 145 0 0 1 320 160" fill="none" stroke="#dc2626" stroke-width="12" stroke-linecap="butt" stroke-dasharray="0 253.1 300"/>

            <defs>
                <linearGradient id="speedGrad" x1="0%" y1="0%" x2="100%" y2="0%">
                    <stop offset="0%" stop-color="#0ea5e9" />
                    <stop offset="58.7%" stop-color="#0ea5e9" />
                    <stop offset="58.7%" stop-color="#ef4444" />
                    <stop offset="100%" stop-color="#ef4444" />
                </linearGradient>
            </defs>

            <!-- Active Speed Dynamic Arc Fill -->
            <path id="speedArcFill" d="M 30 160 A 145 145 0 0 1 320 160" fill="none" stroke="url(#speedGrad)" stroke-width="12" stroke-linecap="round" stroke-dasharray="455.5" stroke-dashoffset="455.5" style="transition: stroke-dashoffset 0.1s linear;"/>
            
            <!-- Outer Tick Marks -->
            <path d="M 15 160 A 160 160 0 0 1 335 160" fill="none" stroke="#ffffff" stroke-width="6" stroke-dasharray="2 22.3" stroke-linecap="butt"/>

            <!-- Speed Numbers (0 to 180 km/h) -->
            <g fill="white" font-size="14" font-weight="normal" text-anchor="middle" dominant-baseline="central">
                <text x="60" y="155">0</text>
                <text x="67" y="121">20</text>
                <text x="87" y="86">40</text>
                <text x="117" y="60">60</text>
                <text x="155" y="47">80</text>
                <text x="195" y="47" fill="#ef4444">100</text>
                <text x="233" y="60" fill="#ef4444">120</text>
                <text x="263" y="86" fill="#ef4444">140</text>
                <text x="283" y="121" fill="#ef4444">160</text>
                <text x="290" y="155" fill="#ef4444">180</text>
            </g>

            <!-- Speedometer Needle -->
            <g id="speedNeedle" style="transform-origin: 175px 160px; transform: rotate(-90deg); transition: transform 0.1s linear;">
                <polygon points="170,165 180,165 175,25" fill="#ffffff" filter="drop-shadow(0 0 5px rgba(255,255,255,0.8))"/>
            </g>
            <circle cx="175" cy="160" r="10" fill="#0ea5e9"/>
        </svg>

        <!-- Digital Center Speed Display -->
        <div class="speed-center-text">
            <div class="speed-val" id="speedValue">0</div>
            <div class="speed-unit">km/h</div>
        </div>
    </div>
</div>
<?php /**PATH C:\laragon\www\hybrid-simulator-laravel\resources\views/simulator/partials/speedometer.blade.php ENDPATH**/ ?>
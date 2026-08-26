{{-- Header & Futuristic Eco-Tech Branding --}}
<header class="cockpit-header">
    {{-- Left Toyota Branding --}}
    <div class="logo-left-box">
        <img src="{{ asset('images/Logo-Toyota-White.png') }}" alt="Toyota" class="logo-left-image">
    </div>

    {{-- Center Header & System Status --}}
    <div class="top-header">
        {{-- <div class="system-status-badge">
            <span class="pulse-indicator"></span>
            <span class="badge-text">ECO-TECH HYBRID DRIVE SIMULATOR</span>
        </div> --}}
        <h1 class="main-system-title">{{ $appTitle ?? 'CARA KERJA MESIN HYBRID' }}</h1>
        <p class="main-system-subtitle">{{ $appSubtitle ?? 'Panduan interaktif memahami sistem penggerak ramah lingkungan.' }}</p>
    </div>

    {{-- Right TAG Branding --}}
    <div class="logo-right-box">
        <img src="{{ asset('images/Logo-TAG-White.png') }}" alt="TAG" class="logo-right-image">
    </div>
</header>

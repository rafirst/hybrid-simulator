{{-- Header & Futuristic Eco-Tech Branding --}}
<header class="cockpit-header">
    {{-- Left Toyota Branding --}}
    <div class="logo-left-box">
        <a href="https://www.tagtoyota.co.id" target="_blank" rel="noopener noreferrer">
            <img src="{{ asset('images/Logo-Toyota-ori.png') }}" alt="Toyota" class="logo-left-image">
        </a>
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
        <a href="https://www.tagtoyota.co.id" target="_blank" rel="noopener noreferrer">
            <img src="{{ asset('images/Logo-TAG-ori.png') }}" alt="TAG" class="logo-right-image">
        </a>
    </div>
</header>

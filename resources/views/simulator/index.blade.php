@extends('layouts.app')

@section('content')
    {{-- Header & Branding --}}
    @include('simulator.partials.header')

    {{-- Main 3-Column Interactive Cockpit --}}
    <div class="main-content">
        {{-- Left Column: Mode Selector --}}
        <div class="left-col">
            @include('simulator.partials.mode_selector')
            @include('simulator.partials.bottom_controls')
        </div>

        {{-- Center Column: 3D Car Visualizer & Description --}}
        <div class="center-col">
            @include('simulator.partials.car_display')
            @include('simulator.partials.mode_description')
        </div>

        {{-- Right Column: Speedometer, Energy Monitor, & Component Status --}}
        <div class="right-col">
            @include('simulator.partials.speedometer')
            @include('simulator.partials.energy_monitor')
            @include('simulator.partials.component_status')
        </div>
    </div>

@endsection

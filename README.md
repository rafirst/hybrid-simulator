# 🚗 Hybrid & Electric Vehicle 3D System Simulator (Laravel Blade + MySQL phpMyAdmin)

Project web aplikasi simulator sistem mobil Hybrid Electric Vehicle (HEV) / Baterai interaktif berbasis **PHP Laravel (Blade Views)**, **Three.js WebGL 3D Engine**, dan basis data **MySQL (phpMyAdmin ready)**.

Project ini mereplikasi **100%** fungsi, kalkulasi visualisasi 3D, instrumen SVG, animasi aliran energi listrik & mekanis, serta efek suara dari simulator hybrid, dengan desain logo dan branding netral modern yang dapat dikustomisasi secara fleksibel.

---

## 🌟 Fitur Utama Simulator

1. **Simulasi 3D Interaktif (Three.js & OrbitControls)**:
   - Visualisasi sasis, bodi transparan (X-Ray Mode), dan tata letak powertrain HEV.
   - **Mesin Bensin (ICE)**, **Motor Listrik (MG2)**, dan **Baterai Hybrid** dengan indikator *glowing emissive* (Aktif / Mati).
   - Kabel & pipa aliran energi 3D dinamis (*CatmullRom curves*) dengan partikel energi bergerak.
   - 4 Roda berputar realistis sesuai kecepatan dengan efek *kinetic energy halo ring*.
   - Pinpoint Label 3D HUD mengambang (*billboard projection*) yang selalu menghadap sudut pandang kamera.
   - Panel **Customize Body**: Pilihan warna (Merah, Putih, Biru), tingkat transparansi (50%, 20%, 0%), dan form upload model 3D `.glb`/`.gltf`.

2. **6 Mode Operasi Hybrid Realistis**:
   - 🔘 **START / IDLE**: Mesin mati, sistem siap (*READY*), efisiensi bahan bakar maksimal.
   - ⚡ **LOW SPEED (EV Mode)**: Digerakkan 100% motor listrik MG2 dari baterai, senyap tanpa emisi.
   - 🚀 **ACCELERATION**: Kombinasi dorongan tenaga Mesin Bensin + Motor Listrik MG2 secara bersamaan.
   - 🏎️ **CONSTANT SPEED**: Kecepatan stabil, mesin bensin bekerja efisien memutar roda + mengisi baterai (*self-charging*).
   - 🔋 **DECELERATION (Regenerative Braking)**: Mesin mati, energi kinetik putaran roda dialirkan kembali oleh motor MG2 menjadi listrik pengisi baterai.
   - 🔄 **REVERSE**: Gigi mundur bertenaga motor listrik MG2 putaran terbalik.

3. **Instrumen Kokpit Digital**:
   - **Speedometer SVG**: Dial speedometer dinamis dengan pembacaan angka digital (0 - 180 km/h), jarum rotasi halus, dan garis gradasi warna.
   - **Energy Monitor SVG**: Skema visual aliran energi dengan animasi dashed flow (Neon Green untuk listrik, Oranye untuk mekanis).
   - **Status Komponen**: Indikator status live untuk Mesin Bensin, Motor MG2, dan Baterai.
   - **Kontrol Shifter**: Tombol START/STOP POWER, Shifter Gigi **D** (Drive), dan Shifter Gigi **R** (Reverse).
   - **Efek Suara (Web Audio)**: Suara sistem power on, mesin, akselerasi, dan regenerative braking.

4. **Backend Laravel & MySQL**:
   - Arsitektur MVC bersih berbasis Laravel Controller & Blade Views.
   - Model & Migrasi tabel `vehicle_models`, `simulation_logs`, dan `settings`.
   - File dump SQL siap import langsung di phpMyAdmin (`database/sql/database_phpmyadmin.sql`).
   - REST API untuk pencatatan log interaksi dan upload model 3D.

---

## 📁 Struktur Direktori Project

```
hybrid-simulator-laravel/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── SimulatorController.php       # Controller utama Blade view
│   │   │   ├── VehicleModelController.php    # API model 3D & Upload
│   │   │   └── SimulationLogController.php   # API logging interaksi
│   │   └── Kernel.php
│   └── Models/
│       ├── VehicleModel.php                  # Model tabel vehicle_models
│       ├── SimulationLog.php                 # Model tabel simulation_logs
│       └── Setting.php                       # Model tabel settings
├── config/                                   # Konfigurasi app, database, filesystem
├── database/
│   ├── migrations/                           # File migrasi Laravel
│   ├── seeders/                              # Seeder data awal
│   └── sql/
│       └── database_phpmyadmin.sql           # File dump SQL siap import ke phpMyAdmin
├── public/
│   ├── css/
│   │   └── simulator.css                     # Desain UI cockpit dark neon
│   ├── js/
│   │   ├── simulator-3d.js                   # Engine 3D Three.js & GLTF
│   │   └── simulator-core.js                 # State, Shifter, Speedometer, Audio & API
│   ├── index.php                             # Entry point aplikasi
│   └── .htaccess                             # Apache rewrite rules
├── resources/
│   └── views/
│       ├── layouts/
│       │   └── app.blade.php                 # Master Blade layout & auto-scaler
│       └── simulator/
│           ├── index.blade.php               # Tampilan utama simulator
│           └── partials/
│               ├── header.blade.php          # Header & branding logos
│               ├── mode_selector.blade.php   # 6 tombol mode
│               ├── car_display.blade.php     # 3D canvas & customize bar
│               ├── mode_description.blade.php# Kartu penjelasan dinamis
│               ├── speedometer.blade.php     # Dial speedometer SVG
│               ├── energy_monitor.blade.php  # Monitor skema energi SVG
│               ├── component_status.blade.php# Indikator mesin/motor/baterai
│               └── bottom_controls.blade.php # Tombol power & shifter D/R
├── routes/
│   ├── web.php                               # Web route
│   └── api.php                               # API route
├── .env.example
├── .env                                      # Konfigurasi MySQL
├── artisan
├── composer.json
└── README.md
```

---

## 🚀 Panduan Menjalankan Project

### Opsi 1: Menggunakan XAMPP / Laragon & phpMyAdmin (Sangat Direkomendasikan)

1. **Import Database di phpMyAdmin**:
   - Buka browser dan akses **`http://localhost/phpmyadmin`**.
   - Klik tab **Databases** -> Buat database baru bernama: `hybrid_simulator`.
   - Pilih database `hybrid_simulator` -> Klik tab **Import**.
   - Pilih file `database/sql/database_phpmyadmin.sql` dari folder project -> Klik **Go / Import**.

2. **Jalankan Aplikasi dengan PHP Artisan**:
   - Buka terminal/cmd di dalam folder project `hybrid-simulator-laravel`.
   - Jalankan perintah:
     ```bash
     composer install
     php artisan serve
     ```
   - Buka browser di: **`http://127.0.0.1:8000`** atau **`http://localhost:8000`**.

---

### Opsi 2: Menggunakan PHP Built-in Server Langsung

Jika ingin langsung menjalankan aplikasi tanpa composer:
- Buka terminal di folder `public`:
  ```bash
  cd public
  php -S localhost:8000
  ```
- Buka browser di: **`http://localhost:8000`**.

---

## 🔑 Informasi Login / Password Upload 3D

- **Password Upload Model 3D**: `Dms1234`
- Format file 3D yang didukung: `.glb` atau `.gltf`

---

## 🎨 Kustomisasi Branding & Logo

Untuk mengganti logo atau tulisan merek:
- Buka file [resources/views/simulator/partials/header.blade.php](file:///C:/Users/User/.gemini/antigravity/brain/d1ce5317-93f3-46cd-8bf3-88fa5738ccb3/hybrid-simulator-laravel/resources/views/simulator/partials/header.blade.php).
- Anda dapat mengubah SVG logo atau menggantinya dengan tag `<img>` ke file logo perusahaan/klien Anda.

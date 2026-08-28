/**
 * Hybrid System Simulator Core Logic & Event Controllers
 */

// Responsive Auto-Scale for 1920x1080 Cockpit
function resizeApp() {
    const wrapper = document.getElementById('appWrapper');
    if (!wrapper) return;

    if (window.matchMedia('(max-width: 900px)').matches) {
        wrapper.style.transform = 'none';
        return;
    }

    const verticalScale = Math.min(window.innerWidth / 1920, window.innerHeight / 1080);
    const horizontalScale = window.innerWidth / 1920;
    wrapper.style.transform = `scaleX(${horizontalScale}) scaleY(${verticalScale})`;
}
window.addEventListener('resize', resizeApp);

/* Sound Effects Web Audio
const audioData = {
    'Intro': new Audio('https://audio.jukehost.co.uk/019efcb8-f837-71f1-8285-f7c52d0190b0'),
    'Idle': new Audio('https://audio.jukehost.co.uk/019efcd1-f81b-7096-8f00-4788fe5200e8'),
    'Low': new Audio('https://audio.jukehost.co.uk/019efcd9-7c37-7369-bd5c-5df5e93c78d1'),
    'Acceleration': new Audio('https://audio.jukehost.co.uk/019efd1d-c7f4-72f4-b388-d2fb1d1688c4'),
    'Constant': new Audio('https://audio.jukehost.co.uk/019efe03-2c7a-73de-9401-cebd5b29f098'),
    'Deceleration': new Audio('https://audio.jukehost.co.uk/019efe03-2c7a-726b-8a69-496ef5743dbd'),
    'Reverse': new Audio('https://audio.jukehost.co.uk/019efe03-2c7a-737b-84e3-012c53cfb038')
};

let currentAudio = null;

function playAudio(modeKey) {
    if (currentAudio) {
        currentAudio.pause();
        currentAudio.currentTime = 0;
    }
    if (audioData[modeKey]) {
        currentAudio = audioData[modeKey];
        currentAudio.play().catch(e => console.log("Audio play blocked or unavailable:", e));
    }
}
*/

// 6 Operating Modes Data & Engineering Descriptions
const modeData = {
    'Idle': {
        title: 'START / IDLE', speed: 0,
        detailHtml: 'Mesin bensin mati untuk menghemat bahan bakar.<br>Sistem <span class="highlight-text">READY</span> untuk dijalankan. Seluruh sistem kelistrikan bersiaga penuh menanti instruksi pengemudi.',
        engine: false, mg2: false, battery: true, flows: [] 
    },
    'Low': {
        title: 'LOW SPEED', speed: 20,
        detailHtml: 'Digerakkan sepenuhnya oleh listrik. Baterai HEV menyalurkan daya tegangan tinggi ke Motor (MG2) yang langsung memutar roda.<br><span class="highlight-text">Tanpa bahan bakar, tanpa emisi, ekstra halus dan senyap.</span><br>Catatan: Berlaku jika daya Baterai HEV > 40%.',
        engine: false, mg2: true, battery: true, flows: ['cableBattMotor', 'flowMgWheel', 'miniFlowBatt', 'miniFlowMotor'] 
    },
    'Acceleration': {
        title: 'ACCELERATION', speed: 65,
        detailHtml: 'Kombinasi dorongan tenaga maksimal dari <span class="highlight-text">Mesin Bensin</span> dan sokongan <span class="highlight-text">Baterai Listrik</span> (melalui Motor MG2) bekerja secara bersamaan.<br>Memberikan torsi akselerasi instan yang kuat dan responsif seketika.',
        engine: true, mg2: true, battery: true, flows: ['cableBattMotor', 'flowMgWheel', 'flowEngWheel', 'miniFlowBatt', 'miniFlowMotor', 'miniFlowEng']
    },
    'Constant': {
        title: 'CONSTANT SPEED', speed: 80,
        detailHtml: 'Mobil melaju stabil, <span class="highlight-mech">utamanya digerakkan oleh Mesin Bensin pada putaran paling efisien</span>.<br>Sebagian kecil tenaga dari putaran roda dan mesin dialihkan untuk memutar Generator (MG1) guna <span class="highlight-text">mengisi ulang daya Baterai</span> secara otomatis tanpa perlu colok listrik.',
        engine: true, mg2: false, battery: true, flows: ['flowEngWheel', 'flowEngMg2Charge', 'cableBattMotorRev', 'miniFlowEng', 'miniFlowEngGen', 'miniFlowCharge'] 
    },
    'Deceleration': {
        title: 'DECELERATION', speed: 45,
        detailHtml: 'Sistem memutus bahan bakar. Mesin Bensin otomatis dimatikan.<br>Energi kinetik mobil saat mengerem dimanfaatkan kembali oleh Motor Listrik (MG2) yang berubah menjadi generator untuk <span class="highlight-text">menghasilkan listrik & mengisi Baterai</span> secara gratis (Regenerative Braking).',
        engine: false, mg2: true, battery: true, flows: ['flowWheelMg', 'cableBattMotorRev', 'miniFlowCharge', 'miniFlowWheelMg'] 
    },
    'Reverse': {
        title: 'REVERSE', speed: 15,
        detailHtml: 'Kendaraan bergerak mundur sepenuhnya digerakkan oleh tenaga putaran terbalik dari <span class="highlight-text">Motor Listrik (MG2)</span>.<br>Mesin bensin dibiarkan tetap mati, membuat proses parkir atau mundur menjadi sangat presisi, halus, dan hening.',
        engine: false, mg2: true, battery: true, flows: ['cableBattMotor', 'flowMgWheel', 'miniFlowBatt', 'miniFlowMotor']
    }
};

window.simState = { isPoweredOn: false, gear: null, mode: 'Off', currentSpeed: 0, targetSpeed: 0 };
const state = window.simState;
const AUTO_MODE_INTERVAL = 15000;
const autoModeSequence = ['Idle', 'Low', 'Acceleration', 'Constant', 'Deceleration', 'Reverse'];
let autoModeTimer = null;
let autoModeIndex = 0;

let ui = {};

function init() {
    resizeApp();

    ui = {
        btnPower: document.getElementById('btnPower'),
        btnD: document.getElementById('gearD'),
        btnR: document.getElementById('gearR'),
        modeBtns: document.querySelectorAll('.mode-btn'),
        displayModeTitle: document.getElementById('displayModeTitle'),
        descTitle: document.getElementById('descTitle'),
        descText: document.getElementById('descText'),
        descIcon: document.getElementById('descIcon'),
        lblEngine: document.getElementById('lblEngine'),
        lblMg2: document.getElementById('lblMg2'),
        lblBattery: document.getElementById('lblBattery'),
        statEngine: document.getElementById('statEngine'),
        statMg2: document.getElementById('statMg2'),
        statBattery: document.getElementById('statBattery'),
        nameEngine: document.getElementById('nameEngine'),
        iconEngine: document.getElementById('iconEngine'),
        nameMg2: document.getElementById('nameMg2'),
        iconMg2: document.getElementById('iconMg2'),
        nameBattery: document.getElementById('nameBattery'),
        iconBattery: document.getElementById('iconBattery'),
        speedValue: document.getElementById('speedValue'),
        speedNeedle: document.getElementById('speedNeedle'),
        speedArcFill: document.getElementById('speedArcFill'),
        btnCustomize: document.getElementById('btnCustomize'),
        customizePanel: document.getElementById('customizePanel'),
        btnUploadModel: document.getElementById('btnUploadModel'),
        modelFileInput: document.getElementById('modelFileInput'),
        uploadStatus: document.getElementById('uploadStatus'),
        bodyColorBtns: document.querySelectorAll('.swatch-btn'),
        bodyOpacityToggle: document.getElementById('bodyOpacityToggle'),
        panelsToDim: document.querySelectorAll('.dimmed')
    };

    if (typeof init3DCar === 'function') {
        init3DCar();
    }
    
    initCustomizeControls();
    
    if (ui.btnPower) ui.btnPower.addEventListener('click', togglePower);
    if (ui.btnD) ui.btnD.addEventListener('click', () => { if(state.isPoweredOn) changeGear('D'); });
    if (ui.btnR) ui.btnR.addEventListener('click', () => { if(state.isPoweredOn) changeGear('R'); });

    ui.modeBtns.forEach(btn => {
        btn.addEventListener('click', (e) => {
            if (!state.isPoweredOn || e.currentTarget.classList.contains('disabled')) return;
            const selectedMode = e.currentTarget.getAttribute('data-mode');
            setMode(selectedMode);
            resetAutoModeTimer(selectedMode);
        });
    });

    animateSpeedometer();
    resetUItoOff();
    togglePower();
}

function togglePower() {
    state.isPoweredOn = !state.isPoweredOn;
    if (state.isPoweredOn) {
        ui.btnPower.classList.add('on');
        ui.panelsToDim.forEach(p => p.classList.remove('dimmed'));
        ui.btnD.classList.remove('disabled');
        ui.btnR.classList.remove('disabled');
        
        // playAudio('Intro');
        changeGear('D'); 
        startAutoModeLoop();
        logInteraction('power_on', { gear: 'D' });
    } else {
        stopAutoModeLoop();
        ui.btnPower.classList.remove('on');
        ui.panelsToDim.forEach(p => p.classList.add('dimmed'));
        
        state.gear = null;
        state.mode = 'Off';
        
        ui.btnD.classList.remove('active');
        ui.btnD.classList.add('disabled');
        ui.btnR.classList.remove('active');
        ui.btnR.classList.add('disabled');
        
        ui.modeBtns.forEach(btn => {
            btn.classList.remove('active');
            btn.classList.add('disabled');
        });

        resetUItoOff();
        logInteraction('power_off');
    }
}

function startAutoModeLoop() {
    stopAutoModeLoop();
    autoModeIndex = 0;
    autoModeTimer = window.setInterval(advanceAutoMode, AUTO_MODE_INTERVAL);
}

function stopAutoModeLoop() {
    if (autoModeTimer !== null) {
        window.clearInterval(autoModeTimer);
        autoModeTimer = null;
    }
}

function resetAutoModeTimer(currentMode) {
    if (!state.isPoweredOn) return;
    const selectedIndex = autoModeSequence.indexOf(currentMode);
    startAutoModeLoop();
    if (selectedIndex !== -1) autoModeIndex = selectedIndex;
}

function advanceAutoMode() {
    if (!state.isPoweredOn) {
        stopAutoModeLoop();
        return;
    }

    autoModeIndex = (autoModeIndex + 1) % autoModeSequence.length;
    const nextMode = autoModeSequence[autoModeIndex];
    const nextGear = nextMode === 'Reverse' ? 'R' : 'D';

    if (state.gear !== nextGear) changeGear(nextGear);
    else setMode(nextMode);
}

function changeGear(gear) {
    state.gear = gear;
    ui.btnD.classList.toggle('active', gear === 'D');
    ui.btnR.classList.toggle('active', gear === 'R');

    ui.modeBtns.forEach(btn => {
        const modeId = btn.getAttribute('data-mode');
        if (gear === 'D') {
            if (modeId === 'Reverse') btn.classList.add('disabled');
            else btn.classList.remove('disabled');
        } else if (gear === 'R') {
            if (modeId === 'Reverse') btn.classList.remove('disabled');
            else btn.classList.add('disabled');
        }
    });

    if (gear === 'D') setMode('Idle');
    if (gear === 'R') setMode('Reverse');

    logInteraction('gear_change', { gear: gear });
}

function setMode(modeId) {
    state.mode = modeId;
    const data = modeData[modeId];
    if (!data) return;
    
    ui.modeBtns.forEach(btn => {
        btn.classList.toggle('active', btn.getAttribute('data-mode') === modeId);
        if(btn.getAttribute('data-mode') === modeId) {
            const svgNode = btn.querySelector('svg');
            if (svgNode) {
                ui.descIcon.innerHTML = svgNode.outerHTML;
            } else {
                ui.descIcon.innerHTML = `<span style="font-size: 45px; font-weight: 900; color: var(--color-electric);">R</span>`;
            }
        }
    });

    ui.displayModeTitle.textContent = data.title;
    ui.descTitle.textContent = data.title;
    ui.descText.innerHTML = data.detailHtml;

    const activeStatusClass = 'txt-green';
    const batteryStatusText = ['Constant', 'Deceleration'].includes(modeId) ? 'Charging' : 'Aktif';
    const batteryStatusClass = batteryStatusText === 'Charging' ? 'txt-green' : activeStatusClass;
    updateStatusLabel(ui.lblEngine, ui.statEngine, data.engine, ui.nameEngine, ui.iconEngine, activeStatusClass);
    updateStatusLabel(ui.lblMg2, ui.statMg2, data.mg2, ui.nameMg2, ui.iconMg2, activeStatusClass);
    updateStatusLabel(ui.lblBattery, ui.statBattery, data.battery, ui.nameBattery, ui.iconBattery, batteryStatusClass, batteryStatusText);

    resetFlowsMini();
    data.flows.forEach(flowId => {
        const el = document.getElementById(flowId);
        if (el) {
            el.style.display = 'block';
            el.classList.add('active');
        }
    });

    state.targetSpeed = data.speed;
    if (typeof update3DVisuals === 'function') {
        update3DVisuals(data, modeId); 
    }
    
    /*
    if(modeId === 'Idle' && currentAudio === audioData['Intro']) {
        // biarkan suara intro
    } else {
        playAudio(modeId);
    }
    */

    logInteraction('mode_change', {
        mode: modeId,
        speed: data.speed,
        engine_active: data.engine,
        mg2_active: data.mg2,
        battery_active: data.battery
    });
}

function updateStatusLabel(lblEl, statEl, isActif, nameEl, iconEl, activeStatusClass = 'txt-green', activeStatusText = 'Aktif') {
    if (!statEl) return;
    const colorClassTxt = isActif ? activeStatusClass : 'txt-red';
    statEl.textContent = isActif ? activeStatusText : 'Mati';
    statEl.className = `kondisi-stat ${colorClassTxt}`;

    if (nameEl && iconEl) {
        if(isActif) {
            nameEl.classList.add('active-name');
            iconEl.classList.add('active-icon');
        } else {
            nameEl.classList.remove('active-name');
            iconEl.classList.remove('active-icon');
        }
    }
}

function resetFlowsMini() {
    const flows = document.querySelectorAll('.arrow-flow'); 
    flows.forEach(f => {
        f.classList.remove('active', 'arrow-rev');
        f.style.display = 'none';
    });
}

function resetUItoOff() {
    ui.displayModeTitle.textContent = 'MATI';
    ui.descTitle.textContent = '-';
    ui.descText.textContent = 'Sistem dalam keadaan mati. Tekan tombol POWER di sudut kiri bawah untuk menyalakan simulasi mobil.';
    ui.descIcon.innerHTML = `<svg viewBox="0 0 24 24"><path d="M17 8C8 10 5.9 16.17 3.82 21.34l1.89.66l.95-2.3c.48.17.96.3 1.34.3C17 20 22 3 22 3c-1 2-8 2.25-13 3.25S2 11.5 2 13.5s1.75 3.75 1.75 3.75C7 8 17 8 17 8z"/></svg>`;
    
    resetFlowsMini();
    state.targetSpeed = 0;
    
    updateStatusLabel(ui.lblEngine, ui.statEngine, false, ui.nameEngine, ui.iconEngine);
    updateStatusLabel(ui.lblMg2, ui.statMg2, false, ui.nameMg2, ui.iconMg2);
    updateStatusLabel(ui.lblBattery, ui.statBattery, false, ui.nameBattery, ui.iconBattery);
    
    if (typeof update3DVisuals === 'function') {
        update3DVisuals({engine: false, mg2: false, battery: false, flows: []}, 'Off');
    }
    
    /* if(currentAudio) {
        currentAudio.pause();
        currentAudio.currentTime = 0;
    } */
}

function animateSpeedometer() {
    if (state.isPoweredOn && state.mode === 'Low') {
        if (state.currentSpeed > 22) {
            state.targetSpeed = 20;
            const diff = state.targetSpeed - state.currentSpeed;
            state.currentSpeed += diff * 0.08;
        } else {
            const time = Date.now() / 600; 
            state.currentSpeed = 10 + Math.sin(time) * 10;
            state.targetSpeed = state.currentSpeed;
        }
    } else if (state.mode === 'Idle' || !state.isPoweredOn) {
        state.targetSpeed = 0;
        const diff = state.targetSpeed - state.currentSpeed;
        state.currentSpeed += diff * 0.08; 
    } else {
        const diff = state.targetSpeed - state.currentSpeed;
        state.currentSpeed += diff * 0.08; 
    }

    if (state.currentSpeed < 0) state.currentSpeed = 0;
    let displaySpeed = Math.round(state.currentSpeed);
    if (ui.speedValue) ui.speedValue.textContent = displaySpeed;
    
    const maxSpeed = 180;
    let angle = (state.currentSpeed / maxSpeed) * 180 - 90;
    if(angle > 90) angle = 90;
    if(angle < -90) angle = -90;

    if (ui.speedNeedle) ui.speedNeedle.style.transform = `rotate(${angle}deg)`;

    if (ui.speedArcFill) {
        const totalDash = 455.5; 
        let percentage = state.currentSpeed / maxSpeed;
        if (percentage < 0) percentage = 0;
        if (percentage > 1) percentage = 1;
        ui.speedArcFill.style.strokeDashoffset = totalDash - (totalDash * percentage);
    }

    requestAnimationFrame(animateSpeedometer);
}

function initCustomizeControls() {
    if (!ui.btnCustomize || !ui.customizePanel) return;

    ui.bodyColorBtns.forEach((btn) => {
        btn.addEventListener('click', () => {
            bodyCustomize.color = btn.getAttribute('data-color') || 'white';
            ui.bodyColorBtns.forEach((item) => item.classList.toggle('active', item === btn));
            if (typeof applyBodyCustomization === 'function') applyBodyCustomization();
            logInteraction('customize', { color: bodyCustomize.color });
        });
    });

    if (ui.bodyOpacityToggle) {
        ui.bodyOpacityToggle.addEventListener('change', () => {
            bodyCustomize.opacity = ui.bodyOpacityToggle.checked ? 0.5 : 0;
            const stateLabel = ui.bodyOpacityToggle.parentElement.querySelector('.toggle-state');
            if (stateLabel) stateLabel.textContent = ui.bodyOpacityToggle.checked ? 'ON' : 'OFF';
            if (typeof applyBodyCustomization === 'function') applyBodyCustomization();
            logInteraction('customize', { opacity: bodyCustomize.opacity });
        });
    }

    if (ui.btnUploadModel && ui.modelFileInput) {
        ui.btnUploadModel.addEventListener('click', requestUploadPassword);
        ui.modelFileInput.addEventListener('change', handleModelUpload);
    }
}

function requestUploadPassword() {
    const password = prompt('Masukkan password untuk upload model:');
    if (password === null) return;
    window._tempUploadPassword = password;
    ui.modelFileInput.click();
}

function handleModelUpload(event) {
    const file = event.target.files && event.target.files[0];
    if (!file) return;

    if (!/\.(glb|gltf)$/i.test(file.name)) {
        setUploadStatus('Format harus .glb atau .gltf');
        event.target.value = '';
        return;
    }

    setUploadStatus('Mengupload model ke server...');
    const reader = new FileReader();
    reader.onload = () => {
        const dataUrl = String(reader.result || '');
        const base64 = dataUrl.split(',')[1];
        
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

        fetch('/api/model/upload', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken || ''
            },
            body: JSON.stringify({
                password: window._tempUploadPassword,
                fileName: file.name,
                mimeType: file.type || 'model/gltf-binary',
                base64: base64
            })
        })
        .then(res => res.json())
        .then(data => {
            if (data.status === 'success') {
                setUploadStatus(data.fileName + ' aktif.');
                alert('Model 3D berhasil diupload dan disimpan!');
            } else {
                setUploadStatus('Upload gagal: ' + (data.message || 'Error'));
                alert('Upload gagal: ' + (data.message || 'Error'));
            }
        })
        .catch(err => {
            console.error('Upload error:', err);
            setUploadStatus('Upload gagal koneksi.');
        });
    };
    reader.onerror = () => setUploadStatus('File gagal dibaca.');
    reader.readAsDataURL(file);
    event.target.value = '';
}

function setUploadStatus(text) {
    if (ui.uploadStatus) ui.uploadStatus.textContent = text;
}

function logInteraction(actionType, data = {}) {
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    fetch('/api/log/interaction', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken || ''
        },
        body: JSON.stringify({
            action_type: actionType,
            gear: state.gear,
            mode: state.mode,
            speed: Math.round(state.currentSpeed),
            ...data
        })
    }).catch(() => {});
}

window.addEventListener('DOMContentLoaded', init);

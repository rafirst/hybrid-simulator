/**
 * 3D Hybrid System Simulator Engine (Three.js WebGL)
 * Exact Toyota Veloz Hybrid 3D Hologram X-Ray Loader & Animation
 */

let scene, camera, renderer, controls;
let carGroup, carModel, fallbackBodyMesh, engineMesh, mg2Mesh, batteryMesh, stageMesh;
let wheels = [];
let flowPaths = []; 
let bodyPanelMaterials = [];
let fixedBlackFrontMaterials = [];
let currentModelObjectUrl = null;

const bodyCustomize = { color: 'white', opacity: 0.5 };
const bodyColorMap = {
    white: 0xf8fafc
};

// 3D Component Global Coordinates matching Veloz Body Geometry
const posEngine = new THREE.Vector3(-12.2, -1.6, 0); 
const posMg2 = new THREE.Vector3(-5.2, -3.0, 0);     
const posBattery = new THREE.Vector3(1.8, -3.15, 0); 
const frontWheelDrivePoint = new THREE.Vector3(-10.15, -2.92, 5.85);

let lblPosEngine, lblPosMg2, lblPosBattery;

function isRearLampMaterial(material) {
    if (!material || !material.color) return false;
    const name = material.name || '';
    const color = material.color;
    const isRedByName = /B22222|maroon|lightcoral|darksalmon/i.test(name);
    const isRedByColor = color.r > 0.45 && color.g < 0.15 && color.b < 0.15;
    return isRedByName || isRedByColor;
}

function isFixedBlackFrontMaterial(mesh, material) {
    return false;
}

function isBodyPanelMaterial(mesh, material) {
    if (!mesh || !material || !material.color) return false;
    return !isRearLampMaterial(material);
}

function isUploadedModelWheelPart(mesh) {
    if (!mesh) return false;
    const meshName = mesh.name || '';
    const materials = Array.isArray(mesh.material) ? mesh.material : [mesh.material];
    const materialNames = materials.map((material) => material && material.name ? material.name : '').join(' ');
    const combinedName = `${meshName} ${materialNames}`;
    const knownVelozWheelMesh = /Toyota Veloz 2022\.0(17|18|19)$/i.test(meshName);
    return knownVelozWheelMesh || /tire|tyre|wheel|rim|vlg|brakerotor|brake rotor|rotor/i.test(combinedName);
}

function registerBodyPanelMaterial(mesh, material) {
    if (!material || !isBodyPanelMaterial(mesh, material)) return;
    if (!bodyPanelMaterials.includes(material)) bodyPanelMaterials.push(material);
}

function registerFixedBlackFrontMaterial(mesh, material) {
    if (!material || isRearLampMaterial(material) || !isFixedBlackFrontMaterial(mesh, material)) return;
    if (!fixedBlackFrontMaterials.includes(material)) fixedBlackFrontMaterials.push(material);
}

function applyFixedFrontMaterials() {
    fixedBlackFrontMaterials.forEach((material) => {
        if (material.map) material.map = null;
        if ('vertexColors' in material) material.vertexColors = false;
        material.color.setHex(0x05070b);
        material.transparent = true;
        material.opacity = 0.59;
        material.depthWrite = false;
        if (material.emissive) material.emissive.setHex(0x000000);
        if ('emissiveIntensity' in material) material.emissiveIntensity = 0;
        if ('metalness' in material) material.metalness = 0.15;
        if ('roughness' in material) material.roughness = 0.42;
        material.needsUpdate = true;
    });
}

function applyBodyCustomization() {
    const selectedColor = bodyColorMap[bodyCustomize.color] || bodyColorMap.white;
    bodyPanelMaterials.forEach((material) => {
        if (material.map) material.map = null;
        if ('vertexColors' in material) material.vertexColors = false;
        material.color.setHex(selectedColor);
        material.transparent = bodyCustomize.opacity < 1;
        material.opacity = bodyCustomize.opacity;
        material.depthWrite = false;
        if (material.emissive) material.emissive.setHex(selectedColor);
        if ('emissiveIntensity' in material) material.emissiveIntensity = bodyCustomize.opacity > 0 ? 0.08 : 0;
        if ('metalness' in material) material.metalness = 0.25;
        if ('roughness' in material) material.roughness = 0.35;
        material.needsUpdate = true;
    });

    if (fallbackBodyMesh && fallbackBodyMesh.material) {
        fallbackBodyMesh.material.color.setHex(selectedColor);
        fallbackBodyMesh.material.transparent = bodyCustomize.opacity < 1;
        fallbackBodyMesh.material.opacity = bodyCustomize.opacity;
        fallbackBodyMesh.material.depthWrite = false;
        fallbackBodyMesh.material.needsUpdate = true;
    }
}

function loadVelozModel() {
    const loadingBadge = document.getElementById('modelLoading');
    if (!THREE.GLTFLoader) {
        if (loadingBadge) loadingBadge.textContent = 'LOADER 3D TIDAK TERSEDIA';
        return;
    }

    const modelUrls = [
        'models/Veloz.glb',
        '/models/Veloz.glb',
        'assets/Veloz.glb',
        '/assets/Veloz.glb',
        'Veloz.glb',
        '/Veloz.glb'
    ];

    loadVelozModelFromUrl(modelUrls[0], modelUrls, 0);
}

function loadVelozModelFromUrl(modelUrl, modelUrls, urlIndex) {
    const loadingBadge = document.getElementById('modelLoading');
    if (loadingBadge) {
        loadingBadge.style.display = 'block';
        loadingBadge.textContent = 'MEMUAT MODEL VELOZ 3D';
    }

    const loader = new THREE.GLTFLoader();
    loader.load(
        modelUrl,
        (gltf) => {
            if (carModel && carGroup) carGroup.remove(carModel);
            bodyPanelMaterials = [];
            fixedBlackFrontMaterials = [];

            carModel = gltf.scene;
            carModel.name = 'Toyota Veloz GLB';

            const firstBox = new THREE.Box3().setFromObject(carModel);
            const firstSize = firstBox.getSize(new THREE.Vector3());
            if (firstSize.z > firstSize.x) carModel.rotation.y = -Math.PI / 2;

            const box = new THREE.Box3().setFromObject(carModel);
            const size = box.getSize(new THREE.Vector3());
            const center = box.getCenter(new THREE.Vector3());
            const targetLength = 31;
            const scale = targetLength / Math.max(size.x, size.y, size.z);

            carModel.scale.setScalar(scale);
            carModel.position.set(
                -center.x * scale,
                -5.3 - box.min.y * scale,
                -center.z * scale
            );

            carModel.traverse((child) => {
                if (!child.isMesh) return;
                if (isUploadedModelWheelPart(child)) {
                    child.visible = false;
                    return;
                }
                child.castShadow = false;
                child.receiveShadow = false;
                child.renderOrder = 2;
                const materials = Array.isArray(child.material) ? child.material : [child.material];
                const xrayMaterials = materials.map((material) => {
                    const clone = material.clone();
                    if (isFixedBlackFrontMaterial(child, clone)) {
                        clone.transparent = true;
                        clone.opacity = 0.59;
                        clone.depthWrite = false;
                        clone.side = THREE.DoubleSide;
                        registerFixedBlackFrontMaterial(child, clone);
                    } else if (isBodyPanelMaterial(child, clone)) {
                        clone.transparent = true;
                        clone.opacity = bodyCustomize.opacity;
                        clone.depthWrite = bodyCustomize.opacity >= 0.5;
                        clone.side = THREE.DoubleSide;
                        registerBodyPanelMaterial(child, clone);
                    }
                    return clone;
                });
                child.material = Array.isArray(child.material) ? xrayMaterials : xrayMaterials[0];
            });

            applyBodyCustomization();
            applyFixedFrontMaterials();
            carGroup.add(carModel);
            if (fallbackBodyMesh) fallbackBodyMesh.visible = false;
            if (loadingBadge) loadingBadge.style.display = 'none';

            const uploadStatus = document.getElementById('uploadStatus');
            if (uploadStatus) uploadStatus.textContent = 'MOBIL: VELOZ HYBRID';
        },
        (xhr) => {
            if (loadingBadge && xhr.total > 0) {
                const percent = Math.round((xhr.loaded / xhr.total) * 100);
                loadingBadge.textContent = 'MEMUAT MODEL VELOZ 3D (' + percent + '%)';
            }
        },
        (error) => {
            console.warn('Gagal memuat URL:', modelUrl, error);
            if (modelUrls && urlIndex + 1 < modelUrls.length) {
                loadVelozModelFromUrl(modelUrls[urlIndex + 1], modelUrls, urlIndex + 1);
            } else {
                console.error('Gagal memuat semua URL model 3D Veloz.');
                if (loadingBadge) loadingBadge.textContent = 'MODEL VELOZ SIAP';
            }
        }
    );
}

function init3DCar() {
    const container = document.getElementById('car3dContainer');
    if (!container) return;
    
    scene = new THREE.Scene();
    scene.background = new THREE.TextureLoader().load('/images/hybrid-bg.png');
    
    camera = new THREE.PerspectiveCamera(30, container.clientWidth / container.clientHeight, 0.1, 1000);
    camera.position.set(40, 15, 55); 
    
    renderer = new THREE.WebGLRenderer({ alpha: true, antialias: true });
    renderer.setSize(container.clientWidth, container.clientHeight);
    renderer.setPixelRatio(window.devicePixelRatio);
    renderer.shadowMap.enabled = false;
    container.appendChild(renderer.domElement);
    
    controls = new THREE.OrbitControls(camera, renderer.domElement);
    controls.enableDamping = true;
    controls.dampingFactor = 0.05;
    controls.maxPolarAngle = Math.PI / 2 - 0.05; 
    controls.minDistance = 20;
    controls.maxDistance = 100;
    
    scene.add(new THREE.AmbientLight(0xffffff, 0.75)); 
    const dirLight = new THREE.DirectionalLight(0xffffff, 0.6);
    dirLight.position.set(15, 30, 15);
    scene.add(dirLight);

    carGroup = new THREE.Group();
    scene.add(carGroup);

    // Load actual Toyota Veloz 3D Model
    loadVelozModel();

    // Stage / Turntable Platform
    const stageGeo = new THREE.CylinderGeometry(24, 24, 0.5, 64);
    const stageMat = new THREE.MeshStandardMaterial({ color: 0xffffff, roughness: 0.9, transparent: true });
    stageMesh = new THREE.Mesh(stageGeo, stageMat);
    stageMesh.position.y = -6;
    scene.add(stageMesh);

    // Procedural Fallback Body (only visible while GLB is loading)
    const shape = new THREE.Shape();
    shape.moveTo(-15.5, -2.5); 
    shape.lineTo(-12.5, -2.5);
    shape.quadraticCurveTo(-9, 1.5, -5.5, -2.5);
    shape.lineTo(5.5, -2.5);
    shape.quadraticCurveTo(9, 1.5, 12.5, -2.5);
    shape.lineTo(13, -2.5);
    shape.quadraticCurveTo(14, -1, 13.5, 1); 
    shape.quadraticCurveTo(12, 6, 6, 6.5);
    shape.lineTo(-1, 6.5); 
    shape.quadraticCurveTo(-3, 6.2, -8, 3.2);
    shape.lineTo(-14, 2);
    shape.quadraticCurveTo(-15.5, 1.8, -16, 0.5);
    shape.quadraticCurveTo(-16.5, -1, -15.5, -2.5);

    const extrudeSettings = { depth: 14, bevelEnabled: true, bevelSegments: 4, steps: 1, bevelSize: 1, bevelThickness: 1 };
    const bodyGeo = new THREE.ExtrudeGeometry(shape, extrudeSettings);
    bodyGeo.translate(0, 0, -7); 
    bodyGeo.computeVertexNormals();

    const carMat = new THREE.MeshPhysicalMaterial({
        color: 0xef4444, transparent: true, opacity: 0.94,
        roughness: 0.1, transmission: 0.8, thickness: 0.5, 
        side: THREE.DoubleSide, depthWrite: false
    });
    const bodyMesh = new THREE.Mesh(bodyGeo, carMat);
    fallbackBodyMesh = bodyMesh;
    fallbackBodyMesh.visible = false; // keep invisible when Veloz model is loaded
    carGroup.add(bodyMesh);

    // Hybrid Powertrain Components (Engine, MG2, Battery)
    const matOff = new THREE.MeshStandardMaterial({ color: 0x222222, roughness: 0.8, metalness: 0.5 }); 
    
    // 1. Engine
    engineMesh = new THREE.Group();
    const engBlock = new THREE.Mesh(new THREE.BoxGeometry(2.8, 2.1, 3.1), matOff.clone());
    const engCyl = new THREE.Mesh(new THREE.CylinderGeometry(0.85, 0.85, 3, 16), matOff.clone());
    engCyl.rotation.z = Math.PI / 2; engCyl.position.y = 1.45;
    engineMesh.add(engBlock, engCyl);
    
    const engEdge = new THREE.LineBasicMaterial({ color: 0xff0000, linewidth: 2 });
    engineMesh.add(new THREE.LineSegments(new THREE.EdgesGeometry(new THREE.BoxGeometry(2.9, 2.2, 3.2)), engEdge));
    engineMesh.position.copy(posEngine);
    carGroup.add(engineMesh);
    
    // 2. Electric Motor (MG2)
    mg2Mesh = new THREE.Group();
    const mg2Body = new THREE.Mesh(new THREE.CylinderGeometry(1.25, 1.25, 3.1, 32), matOff.clone());
    mg2Body.rotation.x = Math.PI / 2;
    mg2Mesh.add(mg2Body);
    
    const mg2Edge = new THREE.LineBasicMaterial({ color: 0xf97316, linewidth: 2 });
    mg2Mesh.add(new THREE.LineSegments(new THREE.EdgesGeometry(new THREE.CylinderGeometry(1.32, 1.32, 3.2, 16)), mg2Edge));
    mg2Mesh.position.copy(posMg2);
    carGroup.add(mg2Mesh);

    // 3. High-Voltage Hybrid Battery
    batteryMesh = new THREE.Group();
    const battBase = new THREE.Mesh(new THREE.BoxGeometry(4.4, 1.7, 3.7), matOff.clone());
    batteryMesh.add(battBase);
    
    const battCells = new THREE.Group();
    for(let i=0; i<5; i++) {
        const cell = new THREE.Mesh(new THREE.BoxGeometry(0.55, 1.85, 3.3), new THREE.MeshStandardMaterial({color: 0x111111}));
        cell.position.x = -1.45 + (i * 0.72);
        battCells.add(cell);
    }
    batteryMesh.add(battCells);
    batteryMesh.userData.cells = battCells; 
    
    const battEdge = new THREE.LineBasicMaterial({ color: 0x22c55e, linewidth: 2 });
    batteryMesh.add(new THREE.LineSegments(new THREE.EdgesGeometry(new THREE.BoxGeometry(4.5, 1.8, 3.8)), battEdge));
    batteryMesh.position.copy(posBattery);
    carGroup.add(batteryMesh);

    // 4 Wheels Setup with Spokes & Kinetic Ring Halo
    const tireGeo = new THREE.TorusGeometry(2.0, 0.5, 16, 48);
    const tireMat = new THREE.MeshStandardMaterial({ color: 0x111111, roughness: 0.9 });
    const rimMat = new THREE.MeshStandardMaterial({ color: 0x8b4f24, emissive: 0x3a1f10, emissiveIntensity: 0.24, metalness: 0.82, roughness: 0.08 });
    const rimFaceMat = new THREE.MeshStandardMaterial({ color: 0x8b4f24, emissive: 0x3a1f10, emissiveIntensity: 0.1, metalness: 0.75, roughness: 0.1, transparent: true, opacity: 0.42, depthWrite: false });
    const rimDarkMat = new THREE.MeshStandardMaterial({ color: 0x0b0b0c, metalness: 0.65, roughness: 0.18 });
    const rimHighlightMat = new THREE.MeshStandardMaterial({ color: 0xc27a3a, emissive: 0x4a2714, emissiveIntensity: 0.22, metalness: 0.88, roughness: 0.08 });
    
    const wheelPos = [ [-10.15, -2.92, 5.85], [9.55, -3.05, 5.85], [-10.15, -2.92, -5.85], [9.55, -3.05, -5.85] ];
    wheelPos.forEach(pos => {
        const wGroup = new THREE.Group();
        const tire = new THREE.Mesh(tireGeo, tireMat);
        tire.scale.z = 1.55;
        wGroup.add(tire);

        const innerRim = new THREE.Mesh(new THREE.TorusGeometry(1.22, 0.08, 12, 36), rimHighlightMat);
        wGroup.add(innerRim);
        const brownFace = new THREE.Mesh(new THREE.CylinderGeometry(1.28, 1.28, 0.08, 48), rimFaceMat);
        brownFace.rotation.x = Math.PI / 2;
        brownFace.position.z = 0.04;
        wGroup.add(brownFace);
        const innerShadow = new THREE.Mesh(new THREE.TorusGeometry(0.92, 0.055, 12, 36), rimDarkMat);
        innerShadow.position.z = 0.1;
        wGroup.add(innerShadow);

        for(let i=0; i<12; i++) {
            const angle = (Math.PI * 2 / 12) * i;
            const spoke = new THREE.Mesh(new THREE.BoxGeometry(0.2, 1.55, 0.16), i % 2 === 0 ? rimHighlightMat : rimMat);
            spoke.position.set(Math.cos(angle) * 0.72, Math.sin(angle) * 0.72, 0.02);
            spoke.rotation.z = angle - Math.PI / 2;
            wGroup.add(spoke);

            const recess = new THREE.Mesh(new THREE.BoxGeometry(0.12, 1.18, 0.1), rimDarkMat);
            recess.position.set(Math.cos(angle + Math.PI / 12) * 0.88, Math.sin(angle + Math.PI / 12) * 0.88, -0.08);
            recess.rotation.z = angle - Math.PI / 2 + Math.PI / 12;
            wGroup.add(recess);
        }
        const center = new THREE.Mesh(new THREE.CylinderGeometry(0.62, 0.62, 0.86, 32), rimMat);
        center.rotation.x = Math.PI/2;
        wGroup.add(center);
        const centerCap = new THREE.Mesh(new THREE.CylinderGeometry(0.34, 0.34, 0.92, 32), rimDarkMat);
        centerCap.rotation.x = Math.PI/2;
        wGroup.add(centerCap);

        // Kinetic Energy Ring Halo
        const greenRingGroup = new THREE.Group();
        const isRightSide = pos[2] > 0;
        const ringZOffset = isRightSide ? 0.88 : -0.88; 

        const arrowShape = new THREE.Shape();
        arrowShape.moveTo(-0.4, 0.35);
        arrowShape.lineTo(0.4, 0);
        arrowShape.lineTo(-0.4, -0.35);
        arrowShape.lineTo(-0.15, 0);
        arrowShape.lineTo(-0.4, 0.35);

        const arrowGeo = new THREE.ShapeGeometry(arrowShape);
        const arrowMat = new THREE.MeshBasicMaterial({
            color: 0xff3333,
            transparent: true, 
            opacity: 0, 
            blending: THREE.AdditiveBlending,
            side: THREE.DoubleSide
        });

        for(let j=0; j<14; j++) {
            const angle = j * Math.PI / 7; 
            const arrow = new THREE.Mesh(arrowGeo, arrowMat);
            arrow.position.set(Math.cos(angle) * 2.0, Math.sin(angle) * 2.0, ringZOffset);
            arrow.rotation.z = angle + Math.PI / 2;
            arrow.scale.setScalar(0.84);
            greenRingGroup.add(arrow);
        }
        wGroup.add(greenRingGroup);
        wGroup.userData.greenRing = greenRingGroup; 

        wGroup.position.set(...pos);
        carGroup.add(wGroup);
        wheels.push(wGroup);
    });

    // 3D Pointer Leader Lines
    function createLabelPointer(startPoint, offsetVector) {
        const endPoint = startPoint.clone().add(offsetVector);
        const points = [startPoint, endPoint];
        const geo = new THREE.BufferGeometry().setFromPoints(points);
        const mat = new THREE.LineDashedMaterial({ color: 0xff0000, dashSize: 0.5, gapSize: 0.3, linewidth: 2, transparent: true, opacity: 0.9, depthTest: false });
        const line = new THREE.Line(geo, mat);
        line.computeLineDistances(); 
        line.renderOrder = 999;
        carGroup.add(line);
        
        const dot = new THREE.Mesh(new THREE.SphereGeometry(0.4, 16, 16), new THREE.MeshBasicMaterial({color: 0xff0000, depthTest: false}));
        dot.position.copy(startPoint);
        dot.renderOrder = 999;
        carGroup.add(dot);
        
        return endPoint;
    }

    lblPosEngine = createLabelPointer(posEngine, new THREE.Vector3(-0.5, 4.8, -2.5)); 
    lblPosMg2 = createLabelPointer(posMg2, new THREE.Vector3(0, -3.4, 4.2));       
    lblPosBattery = createLabelPointer(posBattery, new THREE.Vector3(1.2, 5.2, 3.2)); 

    // Main Red High-Voltage Cable
    const pathBattToFront = [
        posBattery,
        new THREE.Vector3(-2, -3.5, 0),  
        posMg2 
    ];
    const mainCablePath = new THREE.CatmullRomCurve3(pathBattToFront);
    const mainCableGeo = new THREE.TubeGeometry(mainCablePath, 40, 0.4, 8, false);
    const mainCableMat = new THREE.MeshStandardMaterial({ color: 0xff0000, roughness: 0.7 });
    const mainCable = new THREE.Mesh(mainCableGeo, mainCableMat);
    carGroup.add(mainCable);

    // Energy Flow Lines
    function createFlowLine(name, pathPoints, colorHex) {
        const path = new THREE.CatmullRomCurve3(pathPoints);
        const geometry = new THREE.TubeGeometry(path, 30, 0.45, 8, false); 
        
        const material = new THREE.MeshBasicMaterial({ 
            color: colorHex, transparent: true, opacity: 0, wireframe: true 
        });
        const tube = new THREE.Mesh(geometry, material);
        tube.name = name;
        
        const glowGeo = new THREE.SphereGeometry(0.8, 16, 16);
        const glowMat = new THREE.MeshBasicMaterial({ color: colorHex, transparent: true, opacity: 0 });
        const particle = new THREE.Mesh(glowGeo, glowMat);
        
        tube.add(particle);
        tube.userData = { path: path, particle: particle, progress: 0, isRev: false };

        carGroup.add(tube);
        flowPaths.push(tube);
    }

    createFlowLine('cableBattMotor', pathBattToFront, 0xff3333);
    createFlowLine('cableBattMotorRev', pathBattToFront, 0xff3333);
    createFlowLine('flowEngMg2Charge', [posEngine, new THREE.Vector3(-8.5, -2.6, 0), posMg2], 0xff3333);
    createFlowLine('flowEngWheel', [posEngine, frontWheelDrivePoint], 0xf59e0b); 
    createFlowLine('flowMgWheel', [posMg2, frontWheelDrivePoint], 0xf59e0b); 
    createFlowLine('flowWheelMg', [frontWheelDrivePoint, posMg2], 0xff3333); 

    window.addEventListener('resize', () => {
        if (!container || !camera || !renderer) return;
        camera.aspect = container.clientWidth / container.clientHeight;
        camera.updateProjectionMatrix();
        renderer.setSize(container.clientWidth, container.clientHeight);
    });

    animate3D();
}

function update3DLabels() {
    if (!camera || !renderer) return;
    const container = document.getElementById('car3dContainer');
    if (!container) return;
    const halfWidth = container.clientWidth / 2;
    const halfHeight = container.clientHeight / 2;

    function mapPos(pos3D, elementId) {
        const el = document.getElementById(elementId);
        if (!el || !pos3D) return;
        const p = pos3D.clone();
        p.project(camera); 
        
        if (p.z > 1) {
            el.style.display = 'none';
            return;
        }
        el.style.display = 'block';
        el.style.left = (p.x * halfWidth) + halfWidth + 'px';
        el.style.top = -(p.y * halfHeight) + halfHeight + 'px';
    }

    if (lblPosEngine && carGroup) mapPos(lblPosEngine.clone().applyMatrix4(carGroup.matrixWorld), 'lbl3dEngine');
    if (lblPosMg2 && carGroup) mapPos(lblPosMg2.clone().applyMatrix4(carGroup.matrixWorld), 'lbl3dMg2');
    if (lblPosBattery && carGroup) mapPos(lblPosBattery.clone().applyMatrix4(carGroup.matrixWorld), 'lbl3dBattery');
}

function animate3D() {
    requestAnimationFrame(animate3D);
    if (controls) controls.update();

    if (stageMesh && camera) {
        const cameraHeightRatio = camera.position.y / camera.position.length();
        stageMesh.material.opacity = cameraHeightRatio > 0.45
            ? Math.max(0, 1 - ((cameraHeightRatio - 0.45) / 0.25))
            : 1;
    }
    
    if (window.simState && window.simState.currentSpeed > 0 && window.simState.isPoweredOn && window.simState.mode !== 'Idle') {
        const rotationSpeed = (window.simState.mode === 'Reverse' ? -1 : 1) * (window.simState.currentSpeed * 0.004);
        const speedRatio = window.simState.currentSpeed / 180;

        wheels.forEach(wGroup => {
            wGroup.rotation.z += rotationSpeed; 
            if (wGroup.userData.greenRing) {
                wGroup.userData.greenRing.children.forEach(arc => {
                    arc.material.opacity = window.simState.currentSpeed > 5 ? Math.min(speedRatio * 2 + 0.1, 0.8) : 0;
                });
            }
        });
    } else {
        wheels.forEach(wGroup => {
            if (wGroup.userData.greenRing) {
                wGroup.userData.greenRing.children.forEach(arc => arc.material.opacity = 0);
            }
        });
    }

    flowPaths.forEach(tube => {
        if (tube.material.opacity > 0) {
            let data = tube.userData;
            data.progress += (data.isRev ? -0.015 : 0.015);
            if (data.progress > 1) data.progress = 0;
            if (data.progress < 0) data.progress = 1;

            const point = data.path.getPointAt(data.progress);
            data.particle.position.copy(point);
        }
    });

    update3DLabels();
    if (renderer && scene && camera) renderer.render(scene, camera);
}

function update3DVisuals(data, modeId) {
    if (!engineMesh) return; 
    
    const colorOnEng = 0xff0000; 
    const colorOnElec = 0xff3333; 

    const updateGroupColors = (group, isOn, glowColor) => {
        if (!group) return;
        group.children.forEach(child => {
            if (child.isMesh && child.material && !child.userData.isOutline) { 
                child.material.emissive.setHex(isOn ? glowColor : 0x000000);
                child.material.color.setHex(isOn ? 0xffffff : 0x666666);
            }
        });
    };

    updateGroupColors(engineMesh, data.engine, colorOnEng);
    updateGroupColors(mg2Mesh, data.mg2, colorOnElec);
    updateGroupColors(batteryMesh, data.battery, colorOnElec);

    const updateLbl = (elId, isOn, statusText = null, statusClass = null) => {
        const span = document.getElementById(elId);
        if (!span) return;
        if(isOn) {
            span.textContent = statusText || '(AKTIF)';
            span.className = statusClass || (statusText === '(SELF CHARGING)' ? 'lbl-self-charging' : 'lbl-on');
        } else {
            span.textContent = '(MATI)';
            span.className = 'lbl-off';
        }
    };
    updateLbl('st3dEngine', data.engine);
    updateLbl('st3dMg2', data.mg2);
    const batteryStatus = modeId === 'Constant' || modeId === 'Deceleration'
        ? '(SELF CHARGING)'
        : null;
    const batteryStatusClass = ['Idle', 'Low', 'Acceleration', 'Reverse'].includes(modeId)
        ? 'lbl-yellow-active'
        : null;
    updateLbl('st3dBattery', data.battery, batteryStatus, batteryStatusClass);

    const miniEngBox = document.getElementById('miniEngBox');
    if (miniEngBox) {
        miniEngBox.setAttribute('fill', data.engine ? '#ef4444' : '#475569');
        if (data.engine) miniEngBox.classList.add('glow-red-svg');
        else miniEngBox.classList.remove('glow-red-svg');
    }
    const miniMg2Box = document.getElementById('miniMg2Box');
    if (miniMg2Box) {
        miniMg2Box.setAttribute('fill', data.mg2 ? '#00ff41' : '#475569');
        if (data.mg2) miniMg2Box.classList.add('glow-green-svg');
        else miniMg2Box.classList.remove('glow-green-svg');
    }
    const miniBattBox = document.getElementById('miniBattBox');
    const miniBattCells = document.querySelectorAll('.mini-batt-cell');
    if (miniBattBox) {
        miniBattBox.setAttribute('stroke', data.battery ? '#00ff41' : '#475569');
        if (data.battery) miniBattBox.classList.add('glow-green-svg');
        else miniBattBox.classList.remove('glow-green-svg');
        miniBattCells.forEach(c => c.setAttribute('fill', data.battery ? '#00ff41' : '#475569'));
    }

    flowPaths.forEach(tube => {
        tube.material.opacity = 0;
        tube.userData.particle.material.opacity = 0;
        tube.userData.isRev = false;
    });

    data.flows.forEach(flowName => {
        const tube = flowPaths.find(t => t.name === flowName || (flowName === 'cableBattMotorRev' && t.name === 'cableBattMotorRev'));
        if (tube) {
            tube.material.opacity = 0.15; 
            tube.userData.particle.material.opacity = 1; 
            if (flowName === 'cableBattMotorRev') {
                tube.userData.isRev = true;
            }
        }
    });
}

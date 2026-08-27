<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title>TAG - Alur Kerja Hybrid</title>
    <link rel="icon" type="image/png" href="<?php echo e(asset('images/Logo-TAG-favicon-16x16px.png')); ?>">

    <!-- Google Fonts & Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@600;700;800;900&family=Outfit:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Rajdhani:wght@500;600;700;800&display=swap" rel="stylesheet">

    <!-- Three.js 3D Library & Addons -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/three@0.128.0/examples/js/controls/OrbitControls.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/three@0.128.0/examples/js/loaders/GLTFLoader.js"></script>

    <!-- Stylesheets -->
    <?php if(file_exists(public_path('hot')) || file_exists(public_path('build/manifest.json'))): ?>
        <?php echo app('Illuminate\Foundation\Vite')('resources/css/app.css'); ?>
    <?php else: ?>
        <link rel="stylesheet" href="<?php echo e(asset('css/simulator.css')); ?>">
    <?php endif; ?>
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body>

    <div class="app-wrapper" id="appWrapper">
        <?php echo $__env->yieldContent('content'); ?>
    </div>

    <!-- Scripts -->
    <script src="<?php echo e(asset('js/simulator-3d.js')); ?>"></script>
    <script src="<?php echo e(asset('js/simulator-core.js')); ?>"></script>
    <?php echo $__env->yieldPushContent('scripts'); ?>

    <script>
        document.addEventListener('contextmenu', function (event) {
            event.preventDefault();
        });

        document.addEventListener('keydown', function (event) {
            const key = event.key.toLowerCase();
            const isDevToolsShortcut = event.key === 'F12'
                || (event.ctrlKey && event.shiftKey && (key === 'i' || key === 'j'))
                || (event.ctrlKey && key === 'u');

            if (isDevToolsShortcut) {
                event.preventDefault();
                event.stopPropagation();
            }
        }, true);
    </script>
</body>
</html>
<?php /**PATH C:\laragon\www\hybrid-simulator-git\resources\views\layouts\app.blade.php ENDPATH**/ ?>
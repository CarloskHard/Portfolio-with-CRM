@props([
    'variant' => 'viewport',
    'interactive' => true,
])

@php
    $stackClass = $variant === 'section'
        ? 'ai-dots-bg-stack ai-dots-bg-stack--section'
        : 'ai-dots-bg-stack ai-dots-bg-stack--viewport';
@endphp

@once
    <style>
        .ai-dots-bg-stack { pointer-events: none; }
        .ai-dots-bg-stack--viewport {
            position: fixed;
            inset: 0;
            z-index: -1;
            overflow: hidden;
        }
        .ai-dots-bg-stack--section {
            position: absolute;
            inset: 0;
            z-index: 0;
            overflow: hidden;
        }
        .ai-dots-bg-stack .js-ai-dots-canvas {
            display: block;
            width: 100%;
            height: 100%;
            background-color: rgb(245, 245, 240);
        }
        .ai-dots-bg-stack--viewport .js-ai-dots-canvas {
            position: absolute;
            inset: 0;
        }
        .ai-dots-bg-stack .ai-dots-mask-layer {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            background-color: rgb(245, 245, 240);
            mix-blend-mode: lighten;
            z-index: 1;
            overflow: hidden;
        }
        .ai-dots-bg-stack .ai-dots-wave-container {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: rotate(-10deg);
            filter: blur(45px);
        }
        .ai-dots-bg-stack--viewport .ai-dots-wave-container {
            width: 200vw;
            height: 100vh;
            margin-left: -100vw;
            margin-top: -50vh;
        }
        .ai-dots-bg-stack--section .ai-dots-wave-container {
            width: 200%;
            height: 100%;
            margin-left: -100%;
            margin-top: -50%;
        }
        .ai-dots-bg-stack .ai-dots-wave-path {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            will-change: transform;
        }
        .ai-dots-bg-stack .ai-dots-wave-1 {
            animation: aiDotsMoveWave1 4.5s ease-in-out infinite alternate;
        }
        .ai-dots-bg-stack .ai-dots-wave-2 {
            animation: aiDotsMoveWave2 6s ease-in-out infinite alternate-reverse;
        }
        @keyframes aiDotsMoveWave1 {
            0%   { transform: translate(-30vw, -10vh) rotate(-5deg) scaleY(0.8); }
            50%  { transform: translate(0vw, 15vh) rotate(3deg) scaleY(1.1); }
            100% { transform: translate(30vw, -15vh) rotate(-2deg) scaleY(0.9); }
        }
        @keyframes aiDotsMoveWave2 {
            0%   { transform: translate(30vw, 15vh) rotate(5deg) scaleY(1.1); }
            50%  { transform: translate(0vw, -10vh) rotate(-2deg) scaleY(0.9); }
            100% { transform: translate(-30vw, 10vh) rotate(3deg) scaleY(1.2); }
        }
        .ai-dots-bg-stack .js-ai-dots-glow {
            position: absolute;
            width: 550px;
            height: 550px;
            background: radial-gradient(circle, #d5d5d5 0%, transparent 80%);
            border-radius: 50%;
            transform: translate(-50%, -50%);
            mix-blend-mode: multiply;
            filter: blur(40px);
        }
        body:has(> .ai-dots-bg-stack--viewport) .page {
            position: relative;
            z-index: 10;
        }
        @media print {
            .ai-dots-bg-stack { display: none !important; }
        }
    </style>
@endonce

@if($interactive)
<div {{ $attributes->merge(['class' => $stackClass]) }} data-ai-dots-root="{{ $variant }}" aria-hidden="true">
    <canvas class="js-ai-dots-canvas"></canvas>
    <div class="ai-dots-mask-layer">
        <div class="ai-dots-wave-container">
            <svg class="ai-dots-wave-path ai-dots-wave-1" viewBox="0 0 1000 400" preserveAspectRatio="none">
                <path d="M -200,200 C 100,50 300,350 600,200 C 900,50 1100,350 1400,200" fill="none" stroke="black" stroke-width="50" stroke-linecap="round"/>
            </svg>
            <svg class="ai-dots-wave-path ai-dots-wave-2" viewBox="0 0 1000 400" preserveAspectRatio="none">
                <path d="M -200,200 C 200,350 400,50 700,200 C 1000,350 1200,50 1400,200" fill="none" stroke="black" stroke-width="35" stroke-linecap="round"/>
            </svg>
        </div>
        <div class="js-ai-dots-glow ai-dots-glow"></div>
    </div>
</div>

@pushOnce('scripts', 'portfolio-ai-dots-background')
<script>
(function () {
    function initAiDotsRoots() {
        document.querySelectorAll('[data-ai-dots-root]').forEach(function (root) {
            if (root.dataset.aiDotsInit === '1') return;
            root.dataset.aiDotsInit = '1';
            initOneRoot(root);
        });
    }
    function initOneRoot(root) {
        var canvas = root.querySelector('.js-ai-dots-canvas');
        var glow = root.querySelector('.js-ai-dots-glow');
        var maskLayer = root.querySelector('.ai-dots-mask-layer');
        if (!canvas || !glow || !canvas.getContext) return;

        var ctx = canvas.getContext('2d');
        var dots = [];
        var spacing = 28;
        var mouse = { x: -1000, y: -1000, px: -1000, py: -1000, speed: 0, radius: 140, ready: false };

        function Dot(x, y) {
            this.x = x;
            this.y = y;
            this.baseX = x;
            this.baseY = y;
            this.vx = 0;
            this.vy = 0;
        }
        Dot.prototype.update = function () {
            var dx = mouse.x - this.x;
            var dy = mouse.y - this.y;
            var distance = Math.sqrt(dx * dx + dy * dy);
            if (distance < mouse.radius && mouse.speed > 0.5) {
                var force = (mouse.radius - distance) / mouse.radius;
                var angle = Math.atan2(dy, dx);
                var power = mouse.speed * 0.005;
                if (power > 1.2) power = 1.2;
                this.vx -= Math.cos(angle) * force * power;
                this.vy -= Math.sin(angle) * force * power;
            }
            this.x += this.vx;
            this.y += this.vy;
            this.vx *= 0.9;
            this.vy *= 0.9;
            this.x += (this.baseX - this.x) * 0.015;
            this.y += (this.baseY - this.y) * 0.015;
        };
        Dot.prototype.draw = function () {
            ctx.fillStyle = 'rgb(232, 118, 74)';
            ctx.beginPath();
            ctx.arc(this.x, this.y, 1.1, 0, Math.PI * 2);
            ctx.fill();
        };

        function syncSize() {
            var w = Math.max(1, Math.floor(canvas.clientWidth));
            var h = Math.max(1, Math.floor(canvas.clientHeight));
            if (canvas.width !== w || canvas.height !== h) {
                canvas.width = w;
                canvas.height = h;
            }
            dots = [];
            var x = 0;
            for (; x <= canvas.width; x += spacing) {
                var y = 0;
                for (; y <= canvas.height; y += spacing) {
                    dots.push(new Dot(x, y));
                }
            }
        }

        function animate() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            var ds = Math.sqrt(Math.pow(mouse.x - mouse.px, 2) + Math.pow(mouse.y - mouse.py, 2));
            if (ds > 72) ds = 72;
            mouse.speed += (ds - mouse.speed) * 0.1;
            mouse.px = mouse.x;
            mouse.py = mouse.y;
            for (var i = 0; i < dots.length; i++) {
                dots[i].update();
                dots[i].draw();
            }
            requestAnimationFrame(animate);
        }

        function setMouseFromClient(clientX, clientY) {
            var rect = canvas.getBoundingClientRect();
            mouse.x = clientX - rect.left;
            mouse.y = clientY - rect.top;

            var maskRect = maskLayer ? maskLayer.getBoundingClientRect() : rect;
            glow.style.left = (clientX - maskRect.left) + 'px';
            glow.style.top = (clientY - maskRect.top) + 'px';

            if (!mouse.ready) {
                mouse.px = mouse.x;
                mouse.py = mouse.y;
                mouse.speed = 0;
                mouse.ready = true;
            }
        }

        function onMove(e) {
            if ('pointerType' in e && e.pointerType === 'touch') return;
            setMouseFromClient(e.clientX, e.clientY);
        }

        if (typeof ResizeObserver !== 'undefined') {
            var ro = new ResizeObserver(function () { syncSize(); });
            ro.observe(canvas.parentElement || root);
        }
        window.addEventListener('resize', syncSize);
        window.addEventListener('mousemove', onMove, { passive: true });

        syncSize();
        animate();
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initAiDotsRoots);
    } else {
        initAiDotsRoots();
    }
})();
</script>
@endPushOnce

@else
<!-- ai-dots-background: interactive=false (sin capas ni script) -->
@endif

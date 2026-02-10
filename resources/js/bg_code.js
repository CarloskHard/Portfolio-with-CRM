document.addEventListener('DOMContentLoaded', () => {
    const canvas = document.getElementById('code-canvas');
    if (!canvas) return;
    
    const container = canvas.parentElement;
    const ctx = canvas.getContext('2d');

    // --- PANEL DE CONTROL ---
    const layersCount = 4;       
    const lineDensity = 10;     
    const baseFontSize = 15;     
    const hSpeedMin = 0.15;      
    const hSpeedMax = 0.45;      
    const glitchChance = 0.008;  
    
    let width, height;
    let codeLines = [];
    let isVisible = true;
    
    const colors = ['#61afef', '#c678dd', '#98c379', '#e06c75', '#d19a66', '#56b6c2', '#abb2bf'];
    const snippets = [
        'export const useAuth = () => useContext(AuthContext);',
        'public function store(Request $request) {',
        'Route::get("/api/v1/users", [UserController::class, "index"]);',
        'const [data, setData] = useState(null);',
        'return view("dashboard", compact("projects"));',
        'SELECT * FROM users WHERE active = 1 ORDER BY created_at DESC;',
        'git commit -m "feat: added responsive hero section"',
        'docker-compose up -d --build',
        'npm install @tailwindcss/forms alpinejs',
        'if (auth()->user()->isAdmin()) { return redirect()->back(); }',
        'public async Task<IActionResult> GetAsync(int id) {',
        'namespace App\\Http\\Controllers\\Api;',
        'Array.from({ length: 10 }).map((_, i) => i * 2);',
        'while(active) { process.nextTick(); }'
    ];

    function resize() {
        width = canvas.width = container.offsetWidth;
        height = canvas.height = container.offsetHeight;
        initLines();
    }

    function initLines() {
        codeLines = [];
        const totalLines = Math.floor((height / baseFontSize) * lineDensity);

        for (let i = 0; i < totalLines; i++) {
            const layer = Math.floor(Math.random() * layersCount);
            const layerProgress = layersCount > 1 ? (layer / (layersCount - 1)) : 1;
            const layerScale = 0.4 + (layerProgress * 0.6); 
            const content = snippets[Math.floor(Math.random() * snippets.length)];

            // FIX: Repartimos la X entre -width y +width
            // Esto asegura que la pantalla empiece llena y haya flujo constante desde la izquierda
            const initialX = (Math.random() * (width * 2)) - width;

            codeLines.push({
                x: initialX,
                y: Math.random() * height,
                originalContent: content,
                displayContent: content.split(''),
                speed: (hSpeedMin + Math.random() * (hSpeedMax - hSpeedMin)) * layerScale,
                fontSize: baseFontSize * layerScale, 
                alpha: 0.03 + (layerProgress * 0.12), 
                color: colors[Math.floor(Math.random() * colors.length)],
                glitchTimer: 0,
                layer: layer
            });
        }
        
        codeLines.sort((a, b) => a.layer - b.layer);
    }

    function updateGlitch(line) {
        if (line.glitchTimer <= 0 && Math.random() < glitchChance) {
            line.glitchTimer = Math.floor(Math.random() * 25) + 10;
        }

        if (line.glitchTimer > 0) {
            line.glitchTimer--;
            const chars = "!<>-_\\/[]{}—=+*^?";
            const index = Math.floor(Math.random() * line.displayContent.length);
            if (line.glitchTimer > 0) {
                line.displayContent[index] = chars[Math.floor(Math.random() * chars.length)];
            } else {
                line.displayContent = line.originalContent.split('');
            }
        }
    }

    function draw() {
        if (!isVisible) {
            requestAnimationFrame(draw);
            return;
        }

        ctx.clearRect(0, 0, width, height);
        
        codeLines.forEach(line => {
            updateGlitch(line);
            
            ctx.font = `500 ${line.fontSize}px "JetBrains Mono", "Fira Code", monospace`;
            ctx.globalAlpha = line.alpha;
            ctx.fillStyle = line.color;
            
            const textToDraw = line.displayContent.join('');
            
            // Solo dibujamos si está dentro del área visible (opcional, mejora rendimiento)
            if (line.x > -1000 && line.x < width + 100) {
                ctx.fillText(textToDraw, line.x, line.y);
            }
            
            line.x += line.speed;

            if (line.x > width) {
                // Cuando sale por la derecha, reseteamos a la izquierda del todo
                // Usamos un margen generoso para que no "salte" visualmente
                const textWidth = ctx.measureText(textToDraw).width;
                line.x = -textWidth - 200; 
                line.y = Math.random() * height;
                line.color = colors[Math.floor(Math.random() * colors.length)];
            }
        });

        requestAnimationFrame(draw);
    }

    const observer = new IntersectionObserver((entries) => {
        isVisible = entries[0].isIntersecting;
    }, { threshold: 0.05 });

    observer.observe(container);

    window.addEventListener('resize', resize);
    resize();
    draw();
});
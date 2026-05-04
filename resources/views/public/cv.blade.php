<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Carlos Burgos Távora — CV</title>

  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,wght@0,300;0,400;0,500;0,600;1,400&family=DM+Serif+Display&display=swap" rel="stylesheet" />

  <style>
@verbatim
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    :root {
      --accent:     #c75d2c;
      --accent-soft: #e8764a;
      --accent-bg:  #fef6f1;
      --accent-border: rgba(199, 93, 44, 0.22);
      --text:       #1d1d1f;
      --text-mid:   #48484a;
      --muted:      #6e6e73;
      --bg-page:    #f5f5f0;
      --bg-left:    #faf8f5;
      --bg-card:    #fff;
      --divider:    #e8e4de;
      --serif:      'DM Serif Display', serif;
      --sans:       'DM Sans', sans-serif;
    }

    body {
      font-family: var(--sans);
      background: var(--bg-page);
      color: var(--text);
      font-size: 11.5px;
      line-height: 1.6;
      font-weight: 400;
      -webkit-font-smoothing: antialiased;
    }

    /* ── PÁGINA ── */
    .page {
      display: grid;
      grid-template-columns: 260px 1fr;
      max-width: 920px;
      margin: 40px auto;
      background: var(--bg-card);
      box-shadow: 0 1px 3px rgba(0,0,0,.06), 0 12px 48px rgba(0,0,0,.08);
      border-radius: 4px;
      overflow: hidden;
    }

    /* ══════════════════════════════
       COLUMNA IZQUIERDA
    ══════════════════════════════ */
    .left {
      background: var(--bg-left);
      padding: 44px 26px 44px 30px;
      display: flex;
      flex-direction: column;
      gap: 26px;
      border-right: 1px solid var(--divider);
    }

    /* Foto */
    .photo-wrap {
      width: 118px;
      height: 118px;
      margin-bottom: 8px;
      border-radius: 16px;
      overflow: hidden;
      border: 2px solid rgba(244, 156, 113, 0.55);
      box-shadow: 0 4px 18px rgba(244, 156, 113, 0.22), 0 2px 8px rgba(0,0,0,.08);
    }
    .photo-wrap img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      display: block;
    }

    /* Nombre y rol */
    .name-block { display: flex; flex-direction: column; gap: 4px; }
    .name-block h1 {
      font-family: var(--serif);
      font-size: 28px;
      font-weight: 400;
      color: var(--text);
      line-height: 1.05;
      letter-spacing: -0.01em;
    }
    .name-block .role {
      font-size: 12px;
      font-weight: 500;
      color: var(--accent);
      letter-spacing: 0.03em;
      text-transform: uppercase;
      margin-top: 4px;
    }

    /* Contacto */
    .contact-list {
      list-style: none;
      display: flex;
      flex-direction: column;
      gap: 5px;
      margin-top: 4px;
    }
    .contact-list li {
      display: flex;
      align-items: center;
      gap: 7px;
      font-size: 10.5px;
      color: var(--muted);
    }
    .contact-list li svg {
      width: 12px;
      height: 12px;
      flex-shrink: 0;
      color: var(--accent-soft);
      stroke: currentColor;
      fill: none;
      stroke-width: 1.8;
      stroke-linecap: round;
      stroke-linejoin: round;
    }
    .contact-list li svg.fill-icon {
      fill: var(--accent-soft);
      stroke: none;
    }
    .contact-list a {
      color: var(--muted);
      text-decoration: none;
      transition: color .15s;
    }
    .contact-list a:hover { color: var(--accent); }

    /* Sección izquierda */
    .l-section {
      display: flex;
      flex-direction: column;
      gap: 10px;
    }
    .l-title {
      font-family: var(--serif);
      font-size: 14px;
      font-weight: 400;
      color: var(--text);
      padding-bottom: 6px;
      border-bottom: 1.5px solid var(--accent);
      display: inline-block;
    }

    /* ── SKILLS ── */
    .skills-wrapper {
      display: flex;
      flex-direction: column;
      gap: 10px;
    }
    .skill-group {
      display: flex;
      flex-direction: column;
      gap: 5px;
    }
    .skill-cat {
      font-weight: 600;
      font-size: 9.5px;
      color: var(--text-mid);
      text-transform: uppercase;
      letter-spacing: .1em;
    }
    .skill-tags {
      display: flex;
      flex-wrap: wrap;
      gap: 4px;
    }
    .skill-tag {
      background: var(--accent-bg);
      color: var(--accent);
      border: 1px solid var(--accent-border);
      padding: 2px 7px;
      border-radius: 4px;
      font-size: 10px;
      font-weight: 500;
      white-space: nowrap;
    }

    /* Listas simples */
    .simple-list { list-style: none; display: flex; flex-direction: column; gap: 7px; }
    .simple-list li { font-size: 10.5px; color: var(--muted); line-height: 1.45; }
    .simple-list li strong { color: var(--text); font-weight: 500; display: block; margin-bottom: 1px; }
    .idiomas-list li strong { display: inline; margin-bottom: 0; }

    /* ══════════════════════════════
       COLUMNA DERECHA
    ══════════════════════════════ */
    .right {
      background: var(--bg-card);
      padding: 44px 40px 44px 36px;
      display: flex;
      flex-direction: column;
      gap: 0;
    }

    .r-section {
      padding: 22px 0;
      border-bottom: 1px solid var(--divider);
    }
    .r-section:first-child { padding-top: 0; }
    .r-section:last-child  { border-bottom: none; padding-bottom: 0; }

    .r-title {
      display: flex;
      align-items: center;
      gap: 8px;
      font-family: var(--serif);
      font-size: 18px;
      font-weight: 400;
      color: var(--text);
      margin-bottom: 14px;
      padding-left: 12px;
      border-left: 3px solid var(--accent);
    }
    .r-title svg {
      width: 16px;
      height: 16px;
      flex-shrink: 0;
      color: var(--accent-soft);
      stroke: currentColor;
      fill: none;
      stroke-width: 1.6;
      stroke-linecap: round;
      stroke-linejoin: round;
    }

    /* Resumen */
    .summary {
      font-size: 11.5px;
      line-height: 1.75;
      color: var(--text-mid);
    }
    .summary strong {
      color: var(--text);
      font-weight: 500;
    }

    /* Timeline */
    .timeline { display: flex; flex-direction: column; gap: 0; }
    .t-item {
      display: flex;
      flex-direction: column;
      gap: 3px;
      padding: 14px 0 14px 16px;
      border-bottom: 1px dashed var(--divider);
      border-left: 1.5px solid var(--divider);
      position: relative;
    }
    .t-item::before {
      content: '';
      position: absolute;
      left: -4px;
      top: 18px;
      width: 7px;
      height: 7px;
      border-radius: 50%;
      background: var(--accent);
      border: 2px solid var(--bg-card);
    }
    .t-item:first-child { padding-top: 0; }
    .t-item:first-child::before { top: 3px; }
    .t-item:last-child  { border-bottom: none; padding-bottom: 0; }

    .t-top {
      display: flex;
      align-items: baseline;
      justify-content: space-between;
      flex-wrap: wrap;
      gap: 6px;
    }
    .t-title { font-size: 12.5px; font-weight: 600; color: var(--text); }
    .t-date {
      font-size: 10px;
      font-weight: 500;
      color: var(--accent);
      white-space: nowrap;
      letter-spacing: 0.02em;
    }
    .t-company {
      font-size: 11px;
      color: var(--muted);
      font-style: italic;
      margin-bottom: 4px;
    }
    .t-contract {
      font-size: 9.5px;
      color: var(--muted);
      font-style: normal;
      opacity: 0.75;
    }
    .t-bullets { list-style: none; display: flex; flex-direction: column; gap: 4px; }
    .t-bullets li {
      position: relative;
      padding-left: 12px;
      font-size: 11px;
      color: var(--text-mid);
      line-height: 1.5;
    }
    .t-bullets li::before {
      content: '›';
      position: absolute;
      left: 0;
      color: var(--accent);
      font-weight: 600;
    }
    .t-bullets li strong { font-weight: 500; color: var(--text); }

    /* Proyecto destacado inline */
    .project-highlight {
      margin-top: 6px;
      padding: 8px 10px;
      background: var(--accent-bg);
      border-radius: 6px;
      border: 1px solid var(--accent-border);
    }
    .project-highlight .ph-name {
      font-size: 11px;
      font-weight: 600;
      color: var(--accent);
    }
    .project-highlight .ph-desc {
      font-size: 10.5px;
      color: var(--text-mid);
      line-height: 1.5;
      margin-top: 2px;
    }
    .project-highlight .ph-stack {
      font-size: 9.5px;
      color: var(--muted);
      margin-top: 3px;
    }

    /* Bloque electrónica compacto */
    .minor-section {
      padding: 14px 0;
      border-bottom: 1px solid var(--divider);
    }
    .minor-title {
      display: flex;
      align-items: center;
      gap: 8px;
      font-family: var(--serif);
      font-size: 14px;
      font-weight: 400;
      color: var(--muted);
      margin-bottom: 10px;
      padding-left: 12px;
      border-left: 3px solid var(--divider);
    }
    .minor-title svg {
      width: 14px;
      height: 14px;
      flex-shrink: 0;
      color: var(--muted);
      stroke: currentColor;
      fill: none;
      stroke-width: 1.6;
      stroke-linecap: round;
      stroke-linejoin: round;
    }
    .minor-entry {
      display: flex;
      align-items: baseline;
      justify-content: space-between;
      flex-wrap: wrap;
      gap: 4px;
      padding: 4px 0 4px 16px;
    }
    .minor-entry .me-role {
      font-size: 11px;
      font-weight: 500;
      color: var(--text-mid);
    }
    .minor-entry .me-company {
      font-size: 10px;
      color: var(--muted);
      font-style: italic;
    }
    .minor-entry .me-date {
      font-size: 9.5px;
      font-weight: 500;
      color: var(--muted);
      white-space: nowrap;
    }
    .minor-desc {
      font-size: 10.5px;
      color: var(--muted);
      line-height: 1.45;
      padding-left: 16px;
      margin-top: 2px;
    }

    @media print {
      body { background: #fff; }
      .page { box-shadow: none; margin: 0; max-width: 100%; border-radius: 0; }
      .skill-tag { border: 1px solid #ccc; color: #444; background: #f8f8f8; }
      .cv-actions,
      .cv-toast,
      .ai-dots-bg-stack { display: none !important; }
    }
@endverbatim
  </style>
  <style>
    .cv-actions {
      position: fixed;
      top: 14px;
      right: 14px;
      z-index: 100;
      display: flex;
      gap: 8px;
      font-family: 'DM Sans', sans-serif;
    }
    .cv-btn {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 6px;
      padding: 8px 14px;
      font-size: 12px;
      font-weight: 500;
      color: #1d1d1f;
      background: #fff;
      border: 1px solid rgba(199, 93, 44, 0.28);
      border-radius: 6px;
      box-shadow: 0 1px 3px rgba(0,0,0,.08);
      cursor: pointer;
      text-decoration: none;
      transition: background .15s, border-color .15s, color .15s;
    }
    .cv-btn:hover {
      background: #fef6f1;
      border-color: #c75d2c;
      color: #c75d2c;
    }
    .cv-btn svg {
      width: 14px;
      height: 14px;
      flex-shrink: 0;
    }
    .cv-toast {
      position: fixed;
      bottom: 20px;
      left: 50%;
      transform: translateX(-50%) translateY(8px);
      z-index: 101;
      padding: 10px 18px;
      font-family: 'DM Sans', sans-serif;
      font-size: 12px;
      font-weight: 500;
      color: #1d1d1f;
      background: #fff;
      border: 1px solid rgba(199, 93, 44, 0.25);
      border-radius: 8px;
      box-shadow: 0 4px 20px rgba(0,0,0,.12);
      opacity: 0;
      pointer-events: none;
      transition: opacity .2s, transform .2s;
    }
    .cv-toast.cv-toast--visible {
      opacity: 1;
      transform: translateX(-50%) translateY(0);
    }
  </style>
</head>
<body>
@if(empty($downloadMode ?? false))
    <x-ai-dots-background variant="viewport" />
@endif
@if(empty($downloadMode ?? false))
<div class="cv-actions">
  <a href="{{ route('public.cv.download') }}" class="cv-btn" download>
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
    Descargar
  </a>
  <button type="button" class="cv-btn" id="cv-share-btn" aria-label="Copiar enlace al portapapeles">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="18" cy="5" r="3"/><circle cx="6" cy="12" r="3"/><circle cx="18" cy="19" r="3"/><line x1="8.59" y1="13.51" x2="15.42" y2="17.49"/><line x1="15.41" y1="6.51" x2="8.59" y2="10.49"/></svg>
    Compartir
  </button>
</div>
<div class="cv-toast" id="cv-toast" role="status" aria-live="polite">Enlace copiado al portapapeles</div>
@endif
<div class="page">

  <!-- ════════ IZQUIERDA ════════ -->
  <aside class="left">

    <div class="photo-wrap">
      <img src="{{ asset('img/me-noBg.webp') }}" alt="Carlos Burgos Távora" />
    </div>

    <div class="name-block">
      <h1>Carlos Burgos<br>Távora</h1>
      <div class="role">Full Stack Developer</div>

      <ul class="contact-list">
        <li>
          <svg viewBox="0 0 24 24"><path d="M12 2C8.69 2 6 4.69 6 8c0 4.5 6 12 6 12s6-7.5 6-12c0-3.31-2.69-6-6-6z"/><circle cx="12" cy="8" r="2"/></svg>
          Sevilla, España
        </li>
        <li>
          <svg viewBox="0 0 24 24"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="M2 7l10 7 10-7"/></svg>
          <a href="mailto:contacto@carlostavora.dev">contacto@carlostavora.dev</a>
        </li>
        <li>
          <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M2 12h20M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10A15.3 15.3 0 0 1 12 2z"/></svg>
          <a href="https://carlostavora.dev" target="_blank">carlostavora.dev</a>
        </li>
        <li>
          <svg class="fill-icon" viewBox="0 0 24 24"><path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6zM2 9h4v12H2z"/><circle cx="4" cy="4" r="2"/></svg>
          <a href="https://www.linkedin.com/in/carlos-b-6a8a9a2b5/" target="_blank">carlos-b-6a8a9a2b5</a>
        </li>
        <li>
          <svg class="fill-icon" viewBox="0 0 24 24"><path d="M12 .5C5.37.5 0 5.87 0 12.5c0 5.3 3.44 9.8 8.2 11.38.6.1.82-.26.82-.57v-2.23c-3.34.73-4.04-1.41-4.04-1.41-.55-1.38-1.33-1.75-1.33-1.75-1.09-.74.08-.73.08-.73 1.2.08 1.83 1.23 1.83 1.23 1.07 1.83 2.8 1.3 3.48 1 .1-.77.42-1.3.76-1.6-2.66-.3-5.47-1.33-5.47-5.93 0-1.31.47-2.38 1.24-3.22-.12-.3-.54-1.52.12-3.17 0 0 1.01-.32 3.3 1.23a11.5 11.5 0 0 1 3-.4c1.02 0 2.04.14 3 .4 2.28-1.55 3.3-1.23 3.3-1.23.66 1.65.24 2.87.12 3.17.77.84 1.24 1.91 1.24 3.22 0 4.61-2.81 5.63-5.48 5.92.43.37.81 1.1.81 2.22v3.29c0 .32.22.68.82.57C20.56 22.3 24 17.8 24 12.5 24 5.87 18.63.5 12 .5z"/></svg>
          <a href="https://github.com/CarlosBTav" target="_blank">CarlosBTav</a>
        </li>
      </ul>
    </div>

    <!-- Skills -->
    <div class="l-section">
      <h2 class="l-title">Skills</h2>
      <div class="skills-wrapper">
        
        <div class="skill-group">
          <span class="skill-cat">Web & Backend</span>
          <div class="skill-tags">
            <span class="skill-tag">PHP (OOP)</span>
            <span class="skill-tag">Laravel</span>
            <span class="skill-tag">Node.js</span>
            <span class="skill-tag">JavaScript / AJAX</span>
            <span class="skill-tag">Alpine.js</span>
            <span class="skill-tag">Tailwind CSS</span>
            <span class="skill-tag">HTML / CSS</span>
            <span class="skill-tag">REST APIs</span>
          </div>
        </div>

        <div class="skill-group">
          <span class="skill-cat">Mobile</span>
          <div class="skill-tags">
            <span class="skill-tag">Kotlin</span>
            <span class="skill-tag">Jetpack Compose</span>
            <span class="skill-tag">Compose Multiplatform</span>
          </div>
        </div>

        <div class="skill-group">
          <span class="skill-cat">Datos & Infraestructura</span>
          <div class="skill-tags">
            <span class="skill-tag">MySQL / SQL Server</span>
            <span class="skill-tag">Firebase / Firestore</span>
            <span class="skill-tag">Cloud Functions</span>
            <span class="skill-tag">Docker</span>
            <span class="skill-tag">Nginx / Apache</span>
            <span class="skill-tag">Git / Linux</span>
          </div>
        </div>

        <div class="skill-group">
          <span class="skill-cat">ERP & Herramientas</span>
          <div class="skill-tags">
            <span class="skill-tag">Dolibarr</span>
            <span class="skill-tag">PrestaShop</span>
            <span class="skill-tag">Stripe API</span>
          </div>
        </div>

        <div class="skill-group">
          <span class="skill-cat">Otros</span>
          <div class="skill-tags">
            <span class="skill-tag">C# / Unity</span>
            <span class="skill-tag">C++</span>
            <span class="skill-tag">Agile / Scrum</span>
          </div>
        </div>

      </div>
    </div>

    <!-- Soft Skills -->
    <div class="l-section">
      <h2 class="l-title">Soft Skills</h2>
      <ul class="simple-list">
        <li><strong>Comunicación y presentación</strong>
          Experiencia profesional como artista escénico. Soltura para presentar ideas y captar la atención en reuniones o demos.</li>
        <li><strong>Autonomía técnica</strong>
          Gestión de proyectos completos de forma independiente: requisitos, desarrollo, despliegue y soporte al cliente.</li>
        <li><strong>Conciencia de seguridad y producción</strong>
          Enfoque metódico y seguro al manipular entornos de producción (uso estricto de transacciones, copias de seguridad previas y mantenimiento preventivo).</li>
      </ul>
    </div>

    <!-- Idiomas -->
    <div class="l-section">
      <h2 class="l-title">Idiomas</h2>
      <ul class="simple-list idiomas-list">
        <li><strong>Español</strong> — Nativo</li>
        <li><strong>Inglés</strong> — B2</li>
      </ul>
    </div>

  </aside>

  <!-- ════════ DERECHA ════════ -->
  <main class="right">

    <!-- Resumen -->
    <div class="r-section">
      <h2 class="r-title">
        <svg viewBox="0 0 24 24"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.58-7 8-7s8 3 8 7"/></svg>
        Perfil Profesional
      </h2>
      <p class="summary">
        Desarrollador Full Stack con experiencia en la creación y mantenimiento de <strong>software de gestión corporativa</strong> (ERP/CRM, e-commerce) e integraciones con sistemas Legacy, además de <strong>aplicaciones móviles Android</strong> con Kotlin y Jetpack Compose.
        Desarrollo soluciones end-to-end — desde el análisis funcional hasta el despliegue y administración en producción — alineando decisiones técnicas con objetivos de negocio.
        Doble titulación en <strong>DAM y DAW</strong>, con formación en electrónica que aporta un enfoque analítico y riguroso a la resolución de problemas de software.
      </p>
    </div>

    <!-- Experiencia Laboral -->
    <div class="r-section">
      <h2 class="r-title">
        <svg viewBox="0 0 24 24"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 7V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2"/><path d="M2 12h20"/></svg>
        Experiencia Laboral
      </h2>
      <div class="timeline">

        <!-- Freelance -->
        <div class="t-item">
          <div class="t-top">
            <span class="t-title">Desarrollador Web & Mobile — Autónomo</span>
            <span class="t-date">Ene 2025 — Actualidad</span>
          </div>
          <div class="t-company">Clientes B2B · Sevilla</div>
          <ul class="t-bullets">
            <li>Desarrollo y entrega de <strong>aplicaciones web a medida</strong> para clientes empresariales: paneles de gestión interna (ERP), tiendas e-commerce con integración Stripe y portfolios corporativos.</li>
            <li>Gestión completa del ciclo de vida del proyecto: <strong>toma de requisitos, planificación, desarrollo, despliegue y soporte post-lanzamiento</strong> como único punto de contacto técnico.</li>
            <li>Stack principal: <strong>Laravel + Tailwind + Alpine.js</strong>. Infraestructura en VPS con Docker, Nginx, certificados SSL y copias de seguridad automatizadas.</li>
          </ul>
          <div class="project-highlight">
            <div class="ph-name">Platorama — Red social de reseñas gastronómicas</div>
            <div class="ph-desc">App Android publicada en Google Play (Acceso Anticipado). Arquitectura <strong>Clean + MVVM</strong> diseñada e implementada en solitario: autenticación, inyección de dependencias, feed social en tiempo real, sistema de reseñas y notificaciones push.</div>
            <div class="ph-stack">Kotlin · Jetpack Compose · MVVM · Firebase (Firestore, Cloud Functions, FCM) · Material 3</div>
          </div>
        </div>

        <!-- Al Rescate -->
        <div class="t-item">
          <div class="t-top">
            <span class="t-title">Desarrollador Full Stack & Soporte IT</span>
            <span class="t-date">2023 — 2024</span>
          </div>
          <div class="t-company">Al Rescate Asistencia Informática</div>
          <ul class="t-bullets">
            <li><strong>Desarrollo e Integración (PHP/AJAX):</strong> Creación de módulos y automatización de procesos para plataformas ERP (Dolibarr) y CMS (PrestaShop). Programación OOP para generación dinámica de contratos PDF/Word.</li>
            <li><strong>Administración de Bases de Datos:</strong> Diseño y ejecución de consultas SQL complejas para limpieza masiva, deduplicación de registros y saneamiento de BBDD en producción.</li>
            <li><strong>Soporte B2B y Redes:</strong> Atención directa a empresas (Nivel 1 y 2). Resolución de incidencias remotas (TeamViewer/AnyDesk) e interconexión segura de servidores locales y TPVs (VNC, Hamachi).</li>
          </ul>
        </div>

      </div>
    </div>

    <!-- Experiencia previa — Electrónica (sección menor) -->
    <div class="minor-section">
      <h2 class="minor-title">
        <svg viewBox="0 0 24 24"><path d="M2 12h4l3-9 4 18 3-9h6"/></svg>
        Experiencia Previa — Electrónica & IT
      </h2>

      <div class="minor-entry">
        <div>
          <span class="me-role">Especialista Técnico — Ecosistema Apple</span>
          <span class="me-company"> · Goldenmac EDU</span>
        </div>
        <span class="me-date">2019, 2020 y 2022 <span class="t-contract">· Contratos por proyecto</span></span>
      </div>
      <p class="minor-desc">Gestión MDM remota de flotas de dispositivos Apple para centros educativos y soporte técnico especializado hardware/software.</p>

      <div class="minor-entry" style="margin-top: 8px;">
        <div>
          <span class="me-role">Técnico Electrónico</span>
          <span class="me-company"> · NEED TECH</span>
        </div>
        <span class="me-date">Feb 2021 — Abr 2022</span>
      </div>
      <p class="minor-desc">Diseño, montaje SMD automatizado y depuración de PCBs a nivel de componente con instrumental de precisión.</p>

      <div class="minor-entry" style="margin-top: 8px;">
        <div>
          <span class="me-role">Técnico de Ensayos Electrónicos</span>
          <span class="me-company"> · ALTER TECHNOLOGY TÜV NORD</span>
        </div>
        <span class="me-date">2018</span>
      </div>
      <p class="minor-desc">Ensayos de estrés y evaluación de fiabilidad en componentes electrónicos de grado aeroespacial.</p>
    </div>

    <!-- Formación -->
    <div class="r-section" style="border-bottom: none;">
      <h2 class="r-title">
        <svg viewBox="0 0 24 24"><path d="M22 10v6M2 10l10-5 10 5-10 5-10-5z"/><path d="M6 12v5c0 1.66 2.69 3 6 3s6-1.34 6-3v-5"/></svg>
        Formación
      </h2>
      <div class="timeline">

        <div class="t-item">
          <div class="t-top">
            <span class="t-title">CFGS Desarrollo de Aplicaciones Web (DAW)</span>
            <span class="t-date">2024 — 2025</span>
          </div>
        </div>

        <div class="t-item">
          <div class="t-top">
            <span class="t-title">CFGS Desarrollo de Aplicaciones Multiplataforma (DAM)</span>
            <span class="t-date">2021 — 2023</span>
          </div>
        </div>

        <div class="t-item">
          <div class="t-top">
            <span class="t-title">CFGS Mantenimiento Electrónico</span>
            <span class="t-date">2016 — 2018</span>
          </div>
        </div>

      </div>
    </div>

  </main>
</div>
@stack('scripts')
@if(empty($downloadMode ?? false))
<script>
(function () {
  var btn = document.getElementById('cv-share-btn');
  var toast = document.getElementById('cv-toast');
  if (!btn || !toast) return;
  var hideTimer;
  function showToast() {
    toast.classList.add('cv-toast--visible');
    clearTimeout(hideTimer);
    hideTimer = setTimeout(function () { toast.classList.remove('cv-toast--visible'); }, 2200);
  }
  btn.addEventListener('click', function () {
    var url = window.location.href.replace(/#.*$/, '');
    if (navigator.clipboard && navigator.clipboard.writeText) {
      navigator.clipboard.writeText(url).then(showToast).catch(function () {
        fallbackCopy(url);
      });
    } else {
      fallbackCopy(url);
    }
    function fallbackCopy(text) {
      try {
        var ta = document.createElement('textarea');
        ta.value = text;
        ta.setAttribute('readonly', '');
        ta.style.position = 'fixed';
        ta.style.left = '-9999px';
        document.body.appendChild(ta);
        ta.select();
        document.execCommand('copy');
        document.body.removeChild(ta);
        showToast();
      } catch (e) {}
    }
  });
})();
</script>
@endif
</body>
</html>
<svg {{ $attributes->merge(['class' => 'transition-colors duration-300 hover-email']) }} fill="currentColor" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg" style="overflow: visible;">
    <!-- Estado cerrado: exacto al icono original -->
    <g class="email-state-closed">
        <path d="M502.3 190.8c3.9-3.1 9.7-.2 9.7 4.7V400c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V195.6c0-5 5.7-7.8 9.7-4.7 22.4 17.4 52.1 39.5 154.1 113.6 21.1 15.4 56.7 47.8 92.2 47.6 35.7.3 72-32.8 92.3-47.6 102-74.1 131.6-96.3 154-113.7z"></path>
        <path d="M256 320c23.2.4 56.6-29.2 73.4-41.4 132.7-96.3 142.8-104.7 173.4-128.7 5.8-4.5 9.2-11.5 9.2-18.9v-19c0-26.5-21.5-48-48-48H48C21.5 64 0 85.5 0 112v19c0 7.4 3.4 14.3 9.2 18.9 30.6 23.9 40.7 32.4 173.4 128.7 16.8 12.2 50.2 41.8 73.4 41.4z"></path>
    </g>

    <!-- Estado abierto -->
    <g class="email-state-open">
        <path opacity="0.38" d="M48 112h416v288c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V112z"></path>
        <!-- Solapa trasera: se ve solo cuando se abre -->
        <path class="email-open-flap-back" d="M256 320c23.2.4 56.6-29.2 73.4-41.4 132.7-96.3 142.8-104.7 173.4-128.7 5.8-4.5 9.2-11.5 9.2-18.9v-19c0-26.5-21.5-48-48-48H48C21.5 64 0 85.5 0 112v19c0 7.4 3.4 14.3 9.2 18.9 30.6 23.9 40.7 32.4 173.4 128.7 16.8 12.2 50.2 41.8 73.4 41.4z"></path>
        <g class="email-open-letter">
            <rect x="84" y="116" width="344" height="228" rx="10" class="fill-white dark:fill-gray-900" stroke="currentColor" stroke-width="22" />
            <line x1="134" y1="168" x2="378" y2="168" stroke="currentColor" stroke-width="18" stroke-linecap="round" opacity="0.55"/>
            <line x1="134" y1="216" x2="288" y2="216" stroke="currentColor" stroke-width="18" stroke-linecap="round" opacity="0.55"/>
        </g>
        <!-- Solapa delantera: tapa la carta en cerrado -->
        <path class="email-open-flap-front" d="M256 320c23.2.4 56.6-29.2 73.4-41.4 132.7-96.3 142.8-104.7 173.4-128.7 5.8-4.5 9.2-11.5 9.2-18.9v-19c0-26.5-21.5-48-48-48H48C21.5 64 0 85.5 0 112v19c0 7.4 3.4 14.3 9.2 18.9 30.6 23.9 40.7 32.4 173.4 128.7 16.8 12.2 50.2 41.8 73.4 41.4z"></path>
        <path d="M502.3 190.8c3.9-3.1 9.7-.2 9.7 4.7V400c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V195.6c0-5 5.7-7.8 9.7-4.7 22.4 17.4 52.1 39.5 154.1 113.6 21.1 15.4 56.7 47.8 92.2 47.6 35.7.3 72-32.8 92.3-47.6 102-74.1 131.6-96.3 154-113.7z"></path>
    </g>
</svg>
@if(! empty($basicInfo['instagram']['href'] ?? null) || ! empty($basicInfo['email'] ?? null) || ! empty($basicInfo['address'] ?? null))
    <div class="{{ $wrapperClass ?? 'mt-8 rounded-2xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800' }}">
        <h2 class="text-sm font-semibold uppercase tracking-[0.15em] text-gray-500 dark:text-gray-300">
            Información básica
        </h2>
        <ul class="{{ $listClass ?? 'mt-5 space-y-4 text-sm text-gray-800 dark:text-gray-100' }}">
            @if(! empty($basicInfo['instagram']['href'] ?? null))
                <li class="flex gap-3">
                    <span class="mt-0.5 shrink-0 text-pink-600 dark:text-pink-400" aria-hidden="true">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/>
                        </svg>
                    </span>
                    <span>
                        <span class="block text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">Instagram</span>
                        <a href="{{ $basicInfo['instagram']['href'] }}" target="_blank" rel="noopener noreferrer" class="mt-1 inline-block font-medium text-indigo-600 underline decoration-indigo-300 underline-offset-2 hover:text-indigo-500 dark:text-indigo-300 dark:decoration-indigo-500/60 dark:hover:text-indigo-200">{{ $basicInfo['instagram']['label'] ?? __('Instagram') }}</a>
                    </span>
                </li>
            @endif
            @if(! empty($basicInfo['email'] ?? null))
                <li class="flex gap-3">
                    <span class="mt-0.5 shrink-0 text-indigo-600 dark:text-indigo-400" aria-hidden="true">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </span>
                    <span>
                        <span class="block text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">{{ __('Correo') }}</span>
                        <a href="mailto:{{ $basicInfo['email'] }}" class="mt-1 inline-block font-medium text-indigo-600 underline decoration-indigo-300 underline-offset-2 hover:text-indigo-500 dark:text-indigo-300 dark:decoration-indigo-500/60 dark:hover:text-indigo-200">{{ $basicInfo['email'] }}</a>
                    </span>
                </li>
            @endif
            @if(! empty($basicInfo['address'] ?? null))
                <li class="flex gap-3">
                    <span class="mt-0.5 shrink-0 text-gray-500 dark:text-gray-400" aria-hidden="true">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/>
                        </svg>
                    </span>
                    <span>
                        <span class="block text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">{{ __('Dirección') }}</span>
                        <span class="mt-1 block text-gray-800 dark:text-gray-100">{{ $basicInfo['address'] }}</span>
                    </span>
                </li>
            @endif
        </ul>
    </div>
@endif

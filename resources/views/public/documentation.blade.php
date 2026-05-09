@extends('layouts.public')

@section('body-class', 'antialiased font-sans flex flex-col min-h-dynamic transition-colors duration-300 text-gray-900 dark:text-gray-100 about-ai-dots-page')

@section('content')
<div class="relative min-h-dynamic overflow-x-hidden bg-transparent dark:bg-transparent">
    <x-ai-dots-background variant="viewport" />

    <section class="relative z-10 pt-36 pb-20">
        <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">
            @php
                $documentationLogos = $documentation['logos'] ?? [];
            @endphp
            <div class="rounded-3xl border border-gray-200 bg-white/90 p-8 shadow-sm dark:border-gray-700 dark:bg-gray-800/80">
                <div class="flex flex-col gap-4 sm:gap-5">
                    <div class="flex items-start gap-4 sm:gap-5">
                        @if(! empty($documentationLogos['small']['src']))
                            <img
                                src="{{ $documentationLogos['small']['src'] }}"
                                alt="{{ $documentationLogos['small']['label'] ?? 'Favicon' }} — {{ $documentation['client_name'] ?? $documentation['title'] ?? 'Cliente' }}"
                                class="h-12 w-12 shrink-0 rounded-2xl object-contain sm:h-14 sm:w-14"
                                width="56"
                                height="56"
                                loading="lazy"
                                decoding="async"
                            />
                        @endif
                        <div class="min-w-0 flex-1 pt-0.5">
                            <p class="text-xs uppercase tracking-[0.18em] text-indigo-600 dark:text-indigo-300">Documentación compartida</p>
                            <h1 class="mt-2 text-3xl font-semibold text-gray-900 dark:text-gray-100">{{ $documentation['title'] ?? 'Proyecto' }}</h1>
                        </div>
                    </div>
                    @if(!empty($documentation['domain']))
                        <p class="text-sm text-gray-600 dark:text-gray-300">
                            Dominio:
                            <a href="https://{{ $documentation['domain'] }}" target="_blank" rel="noopener noreferrer" class="font-medium text-indigo-600 underline decoration-indigo-300 underline-offset-2 hover:text-indigo-500 dark:text-indigo-300 dark:decoration-indigo-500/60 dark:hover:text-indigo-200">
                                {{ $documentation['domain'] }}
                            </a>
                        </p>
                    @endif
                    @if(!empty($documentation['development_url']))
                        <p class="text-sm text-gray-600 dark:text-gray-300">
                            URL de desarrollo:
                            <a href="{{ $documentation['development_url'] }}" target="_blank" rel="noopener noreferrer" class="font-medium text-indigo-600 underline decoration-indigo-300 underline-offset-2 hover:text-indigo-500 dark:text-indigo-300 dark:decoration-indigo-500/60 dark:hover:text-indigo-200">
                                {{ $documentation['development_url'] }}
                            </a>
                        </p>
                    @endif
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        Actualizado: <span class="font-normal">{{ $documentation['updated_at'] ?? now()->toDateString() }}</span>
                    </p>
                </div>

                @if(! empty($documentationLogos['large']['src']))
                    <div class="mt-6 border-t border-gray-200 pt-6 dark:border-gray-600">
                        <h2 class="text-sm font-semibold uppercase tracking-[0.15em] text-gray-500 dark:text-gray-300">
                            Logotipos
                        </h2>
                        <div class="mt-4">
                            <p class="mb-2 text-xs font-medium text-gray-500 dark:text-gray-400">
                                {{ $documentationLogos['large']['label'] ?? 'Logo grande' }}
                            </p>
                            <div class="inline-block rounded-lg border border-gray-200 bg-gray-50/80 p-3 dark:border-gray-600 dark:bg-gray-700/40">
                                <img
                                    src="{{ $documentationLogos['large']['src'] }}"
                                    alt="Logo grande — {{ $documentation['client_name'] ?? $documentation['title'] ?? 'Cliente' }}"
                                    class="max-h-24 w-auto max-w-[min(100%,16rem)] object-contain sm:max-h-28"
                                    loading="lazy"
                                    decoding="async"
                                />
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            @include('partials.documentation-basic-info', [
                'basicInfo' => $documentation['basic_information'] ?? [],
            ])

            @if(!empty($documentation['pending_information']) && is_array($documentation['pending_information']))
                <div class="mt-8 rounded-2xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800">
                    <div class="flex flex-wrap items-center justify-between gap-3">
                        <h2 class="text-sm font-semibold uppercase tracking-[0.15em] text-gray-500 dark:text-gray-300">
                            Información por aclarar
                        </h2>
                    </div>
                    <ul class="mt-4 space-y-2 text-sm text-gray-700 dark:text-gray-200">
                        @foreach($documentation['pending_information'] as $item)
                            <li>- {{ $item }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if(!empty($documentation['confirmed_information']) && is_array($documentation['confirmed_information']))
                <div class="mt-8 rounded-2xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800">
                    <h2 class="text-sm font-semibold uppercase tracking-[0.15em] text-gray-500 dark:text-gray-300">
                        Información de la web
                    </h2>
                    <dl class="mt-4 space-y-3">
                        @foreach($documentation['confirmed_information'] as $item)
                            <div class="rounded-xl border border-gray-200 bg-gray-50/70 px-4 py-3 dark:border-gray-600 dark:bg-gray-700/40">
                                <dt class="text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-300">
                                    {{ $item['label'] ?? 'Dato' }}
                                </dt>
                                <dd class="mt-1 text-sm text-gray-800 dark:text-gray-100">
                                    @if(!empty($item['href']))
                                        <span class="inline-flex flex-wrap items-center gap-2">
                                            @if(($item['icon'] ?? '') === 'instagram')
                                                <svg class="h-5 w-5 shrink-0 text-pink-600 dark:text-pink-400" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                                    <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/>
                                                </svg>
                                            @endif
                                            <a href="{{ $item['href'] }}" target="_blank" rel="noopener noreferrer" class="font-medium text-indigo-600 underline decoration-indigo-300 underline-offset-2 hover:text-indigo-500 dark:text-indigo-300 dark:decoration-indigo-500/60 dark:hover:text-indigo-200">
                                                {{ $item['value'] ?? $item['href'] }}
                                            </a>
                                        </span>
                                    @else
                                        {{ $item['value'] ?? '-' }}
                                    @endif
                                </dd>
                            </div>
                        @endforeach
                    </dl>
                </div>
            @endif
        </div>
    </section>
</div>
@endsection

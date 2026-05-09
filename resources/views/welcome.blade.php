@extends('layouts.public')

@php
    $basicInfo = config('documentation.versions.musical-luthier.basic_information', []);
@endphp

@section('title', 'Información básica — Musical Luthier')

@section('content')
    <section class="relative z-10 mx-auto max-w-4xl px-4 py-20">
        <div class="rounded-3xl border border-gray-200 bg-white/90 p-8 shadow-sm dark:border-gray-700 dark:bg-gray-800/80">
            <p class="text-xs uppercase tracking-[0.18em] text-indigo-600 dark:text-indigo-300">Musical Luthier</p>
            @include('partials.documentation-basic-info', [
                'basicInfo' => $basicInfo,
                'wrapperClass' => 'mt-6 border-0 bg-transparent p-0 shadow-none dark:bg-transparent',
                'listClass' => 'mt-5 space-y-4 text-sm text-gray-800 dark:text-gray-100',
            ])
        </div>
    </section>
@endsection

@props(['messages'])

@if ($messages)
    <ul
        role="alert"
        {{ $attributes->merge(['class' => 'input-error-list mt-1.5 flex flex-wrap items-center gap-1.5 text-sm text-indigo-600 dark:text-indigo-400 space-y-0']) }}
    >
        @foreach ((array) $messages as $message)
            <li class="inline-flex items-center gap-1.5 rounded-md border border-indigo-200/70 bg-indigo-50/80 px-2 py-1 dark:border-indigo-500/20 dark:bg-indigo-950/20">
                <svg class="h-4 w-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                </svg>
                <span>{{ $message }}</span>
            </li>
        @endforeach
    </ul>
@endif

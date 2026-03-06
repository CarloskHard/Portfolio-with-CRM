@props(['errors', 'title' => 'Revisa el formulario'])

@if ($errors && (is_countable($errors) ? count($errors) > 0 : $errors->isNotEmpty()))
    <div
        role="alert"
        aria-live="polite"
        {{ $attributes->merge(['class' => 'form-errors-summary']) }}
    >
        <div class="flex gap-3 rounded-xl border border-indigo-200/80 bg-indigo-50/60 px-4 py-3 dark:border-indigo-500/30 dark:bg-indigo-950/30">
            <span class="flex shrink-0 items-center justify-center rounded-full bg-indigo-100 dark:bg-indigo-900/50 p-1.5" aria-hidden="true">
                <svg class="h-5 w-5 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                </svg>
            </span>
            <div class="min-w-0 flex-1">
                <p class="text-sm font-semibold text-gray-800 dark:text-gray-100">
                    {{ $title }}
                </p>
                <ul class="mt-1.5 list-inside list-disc space-y-0.5 text-sm text-gray-700 dark:text-gray-300">
                    @foreach (is_array($errors) ? $errors : $errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endif

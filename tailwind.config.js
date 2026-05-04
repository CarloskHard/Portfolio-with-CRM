import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'class', //Habilita modo oscuro
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            colors: {
                /* ── Primary (mint / teal) ── */
                primary: {
                    DEFAULT: 'var(--color-primary)',
                    light:   'var(--color-primary-light)',
                    dark:    'var(--color-primary-dark)',
                },
                /* ── Secondary (indigo) ── */
                secondary: {
                    DEFAULT: 'var(--color-secondary)',
                    light:   'var(--color-secondary-light)',
                    dark:    'var(--color-secondary-dark)',
                },
                /* ── Semantic ── */
                success: 'var(--color-success)',
                error:   'var(--color-error)',
                warning: 'var(--color-warning)',
                info:    'var(--color-info)',
                /* ── Legacy alias ── */
                brand: {
                    mint: '#9ad1d2',
                },
            },
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [forms],
};

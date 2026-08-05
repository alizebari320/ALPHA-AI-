import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'class',
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            colors: {
                graphite: '#0c0c0e',
                ink: '#0c0c0e',
                panel: '#151518',
                gold: '#f0b429',
                golddeep: '#a16207',
                cream: '#f3efe6',

                // AI Tools directory — exact spec palette
                surface: '#0D0D0E',
                card: '#18181B',
                accent: '#F59E0B',
                edge: '#27272A',
            },
            fontFamily: {
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
                display: ['Oswald', 'sans-serif'],
                mega: ['Bebas Neue', 'sans-serif'],
                mono: ['JetBrains Mono', ...defaultTheme.fontFamily.mono],
                kurdish: ['"Noto Naskh Arabic"', '"Segoe UI"', 'Tahoma', 'sans-serif'],
            },
            boxShadow: {
                offset: '4px 4px 0px 0px rgba(245,158,11,0.2)',
                'offset-lg': '6px 6px 0px 0px rgba(245,158,11,0.35)',
            },
            keyframes: {
                'card-in': {
                    '0%': { opacity: '0', transform: 'translateY(14px) scale(.97)' },
                    '100%': { opacity: '1', transform: 'translateY(0) scale(1)' },
                },
                'modal-in': {
                    '0%': { opacity: '0', transform: 'translateY(24px) scale(.96)' },
                    '100%': { opacity: '1', transform: 'translateY(0) scale(1)' },
                },
                'toast-in': {
                    '0%': { opacity: '0', transform: 'translateY(16px)' },
                    '100%': { opacity: '1', transform: 'translateY(0)' },
                },
            },
            animation: {
                'card-in': 'card-in .38s cubic-bezier(.16,1,.3,1) both',
                'modal-in': 'modal-in .3s cubic-bezier(.16,1,.3,1) both',
                'toast-in': 'toast-in .28s cubic-bezier(.16,1,.3,1) both',
            },
        },
    },

    plugins: [forms],
};

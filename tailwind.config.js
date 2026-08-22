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
                bg: '#07080c',
                'bg-elevated': '#10121a',
                'bg-muted': '#0c0e14',
                fg: '#f4f5f7',
                'fg-muted': '#9a9eac',
                'fg-faint': '#5c6070',
                border: '#242733',
                'border-strong': '#3a3e4c',

                primary: '#8b7cff',
                'primary-hover': '#a59aff',
                'primary-light': 'rgba(139, 124, 255, 0.14)',
                'primary-glow': 'rgba(139, 124, 255, 0.24)',

                accent: '#b8ff5c',
                'accent-hover': '#d0ff91',
                'accent-light': 'rgba(184, 255, 92, 0.12)',
                'accent-glow': 'rgba(184, 255, 92, 0.2)',

                // Compatibility aliases for existing AlphaAi views.
                void: '#07080c',
                surface: '#0c0e14',
                card: '#10121a',
                edge: '#242733',
                'neon-blue': '#8b7cff',
                'neon-cyan': '#b8ff5c',

                success: '#1a7f3f',
                'success-light': '#eaf7ee',
                warning: '#b87300',
                'warning-light': '#fff8e1',
                error: '#c0392b',
                'error-light': '#fdeceb',

                // Dark mode (handled via CSS variables in :root/.dark)
            },
            fontFamily: {
                sans: ['Inter', 'Noto Kufi Arabic', ...defaultTheme.fontFamily.sans],
                display: ['Space Grotesk', 'Noto Kufi Arabic', ...defaultTheme.fontFamily.sans],
                mono: ['JetBrains Mono', ...defaultTheme.fontFamily.mono],
            },
            fontSize: {
                'display-xl': ['clamp(3rem, 8vw, 6rem)', { lineHeight: '1.05', letterSpacing: '-0.02em', fontWeight: '600' }],
                'display-lg': ['clamp(2.5rem, 6vw, 4.5rem)', { lineHeight: '1.1', letterSpacing: '-0.02em', fontWeight: '600' }],
                'display-md': ['clamp(2rem, 5vw, 3.5rem)', { lineHeight: '1.15', letterSpacing: '-0.02em', fontWeight: '600' }],
                'display-sm': ['clamp(1.5rem, 3vw, 2.25rem)', { lineHeight: '1.2', letterSpacing: '-0.02em', fontWeight: '600' }],
            },
            borderRadius: {
                'sm': '6px',
                DEFAULT: '10px',
                'lg': '16px',
                'xl': '24px',
                'full': '9999px',
            },
            boxShadow: {
                'sm': '0 1px 2px rgba(15, 20, 30, 0.04)',
                DEFAULT: '0 4px 16px -4px rgba(15, 20, 30, 0.08), 0 2px 6px -2px rgba(15, 20, 30, 0.04)',
                'lg': '0 20px 40px -12px rgba(15, 20, 30, 0.12), 0 8px 16px -8px rgba(15, 20, 30, 0.06)',
                'xl': '0 32px 64px -16px rgba(15, 20, 30, 0.15)',
            },
            transitionDuration: {
                DEFAULT: '200ms',
                'slow': '350ms',
            },
            transitionTimingFunction: {
                DEFAULT: 'cubic-bezier(0.2, 0.8, 0.2, 1)',
            },
            keyframes: {
                'fade-in': {
                    '0%': { opacity: '0' },
                    '100%': { opacity: '1' },
                },
                'slide-up': {
                    '0%': { opacity: '0', transform: 'translateY(24px)' },
                    '100%': { opacity: '1', transform: 'translateY(0)' },
                },
                'scale-in': {
                    '0%': { opacity: '0', transform: 'scale(0.96)' },
                    '100%': { opacity: '1', transform: 'scale(1)' },
                },
                'pulse-ring': {
                    '0%': { boxShadow: '0 0 0 0 rgba(163, 255, 60, 0.7)' },
                    '70%': { boxShadow: '0 0 0 10px rgba(163, 255, 60, 0)' },
                    '100%': { boxShadow: '0 0 0 0 rgba(163, 255, 60, 0)' },
                },
            },
            animation: {
                'fade-in': 'fade-in 500ms ease',
                'slide-up': 'slide-up 600ms cubic-bezier(0.2, 0.8, 0.2, 1)',
                'scale-in': 'scale-in 500ms cubic-bezier(0.2, 0.8, 0.2, 1)',
                'pulse-ring': 'pulse-ring 2.4s cubic-bezier(0.4, 0, 0.6, 1) infinite',
            },
        },
    },

    plugins: [forms],
};

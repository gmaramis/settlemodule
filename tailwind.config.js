import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            // Optimize animations
            animation: {
                'fade-in': 'fadeIn 0.3s ease-in-out',
                'slide-up': 'slideUp 0.3s ease-out',
                'pulse-slow': 'pulse 3s cubic-bezier(0.4, 0, 0.6, 1) infinite',
            },
            keyframes: {
                fadeIn: {
                    '0%': { opacity: '0' },
                    '100%': { opacity: '1' },
                },
                slideUp: {
                    '0%': { transform: 'translateY(10px)', opacity: '0' },
                    '100%': { transform: 'translateY(0)', opacity: '1' },
                },
            },
            // Optimize spacing
            spacing: {
                '18': '4.5rem',
                '88': '22rem',
            },
            // Optimize colors
            colors: {
                'settle-blue': '#3B82F6',
                'settle-green': '#10B981',
                'settle-red': '#EF4444',
                'settle-yellow': '#F59E0B',
                'settle-purple': '#8B5CF6',
            },
        },
    },

    plugins: [
        forms,
        // Add custom utilities
        function({ addUtilities }) {
            addUtilities({
                '.text-optimize': {
                    'text-rendering': 'optimizeLegibility',
                    '-webkit-font-smoothing': 'antialiased',
                    '-moz-osx-font-smoothing': 'grayscale',
                },
                '.animate-smooth': {
                    'transition': 'all 0.3s cubic-bezier(0.4, 0, 0.2, 1)',
                },
            });
        },
    ],

    // Optimize for production
    future: {
        hoverOnlyWhenSupported: true,
    },
};

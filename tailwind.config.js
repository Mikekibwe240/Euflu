import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'class', // Ajouté pour activer le mode sombre via la classe 'dark'
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
                bundesliga: ['Montserrat', 'Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                'bl-dark': '#191e24',
                'bl-card': '#23272a',
                'bl-accent': '#e2001a', // Harmonisé avec le logo/header
                'bl-gray': '#c9cccf',
                'bl-border': '#31363a',
            },
        },
    },

    plugins: [forms],
};

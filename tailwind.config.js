import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                // Paleta da marca Fontoura Desenvolvimento (baseada no logo)
                brand: {
                    // Laranja do dragão (gradiente #F7941D -> #F26522)
                    orange: {
                        50: '#fff5ec',
                        100: '#ffe6cf',
                        200: '#ffc99e',
                        300: '#ffa762',
                        400: '#fb8b3a',
                        500: '#f7941d', // laranja claro do gradiente
                        600: '#f26522', // laranja mais quente do gradiente
                        700: '#d24e12',
                        800: '#a83d13',
                        900: '#873514',
                    },
                    // Roxo escuro / quase preto do texto "FONTOURA"
                    dark: {
                        50: '#f6f4f7',
                        100: '#e9e4ec',
                        200: '#cfc5d4',
                        300: '#a99bb1',
                        400: '#7c6b86',
                        500: '#584862',
                        600: '#43354b',
                        700: '#2e1a2f', // roxo escuro principal
                        800: '#231524',
                        900: '#1a1020', // quase preto
                    },
                },
            },
        },
    },

    plugins: [forms],
};

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
                serif: ['Playfair Display', ...defaultTheme.fontFamily.serif],
            },
            colors: {
                bookty: {
                    pink: {
                        50: '#FEF6F6',
                        100: '#FCE7E7',
                        200: '#F8D0D0',
                        300: '#F3B8B8',
                        400: '#EEA0A0',
                        500: '#E98888',
                        600: '#E46D6D',
                        700: '#DF5252',
                        800: '#DA3737',
                        900: '#D51C1C',
                    },
                    purple: {
                        50: '#F6F4F9',
                        100: '#EDE9F2',
                        200: '#DAD3E6',
                        300: '#C8BDD9',
                        400: '#B5A6CD',
                        500: '#A390C0',
                        600: '#907AB3',
                        700: '#7D63A7',
                        800: '#6B4D9A',
                        900: '#58368E',
                    },
                    black: '#1A1A1A',
                    cream: '#F9F3F0',
                }
            },
        },
    },

    plugins: [forms],
};

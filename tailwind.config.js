import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';

const colors = require('tailwindcss/colors');

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
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
                transparent: 'transparent',
                current: 'currentColor',
                black: colors.black,
                white: colors.white,
                emerald: colors.emerald,
                indigo: colors.indigo,
                yellow: colors.yellow,
                lime: colors.lime,
                rose: colors.rose,
            },
            borderWidth: {
                DEFAULT: '6px',
                0: '0',
                1: '1px',
                2: '2px',
                3: '3px',
                4: '4px',
                5: '5px',
                6: '7px',
                7: '10px',
                8: '15px',
                9: '20px',
            },
        },
    },

    plugins: [forms, typography, require('@tailwindcss/forms'),],
};

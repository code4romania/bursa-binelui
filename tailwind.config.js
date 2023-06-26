const defaultTheme = require('tailwindcss/defaultTheme');
const colors = require('tailwindcss/colors');

/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        './app/**/*.php',
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/filament/**/*.blade.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
            },

            colors: {
                red: {
                    500: '#FA6F55'
                },
                primary: {
                    50: '#D9F1F1',
                    100: '#CAEBEB',
                    200: '#ACE0E0',
                    300: '#8ED5D5',
                    400: '#71CACA',
                    500: '#53BFBF',
                    600: '#3B9F9F',
                    700: '#2C7676',
                    800: '#1D4D4D',
                    900: '#0D2424',
                },
                danger: colors.rose,
                success: colors.green,
                warning: colors.yellow,
            },
            zIndex: {
                '100': '1000',
                '101': '1001'
            },
            maxHeight: {
                '128': '32rem',
            }
        },
    },

    plugins: [
        require('@tailwindcss/forms'),
        require('@tailwindcss/aspect-ratio'),
        require('@tailwindcss/typography'),
    ],
};

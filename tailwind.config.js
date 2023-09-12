const defaultTheme = require('tailwindcss/defaultTheme');
const colors = require('tailwindcss/colors');

/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        './app/**/*.php',
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/awcodes/filament-tiptap-editor/resources/views/**/*.blade.php',
        './vendor/filament/**/*.blade.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        container: ({ theme }) => ({
            center: true,
            padding: {
                DEFAULT: '1rem',
                sm: '1.5rem',
                lg: '2rem',
            },
            screens: {
                DEFAULT: theme('screens.xl')
            },
        }),
        extend: {
            fontFamily: {
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
            },

            colors: {
                red: {
                    500: '#FA6F55'
                },
                primary: {
                    50: '#ECF8F8',
                    100: '#DEF3F3',
                    200: '#B8E5E5',
                    300: '#97D8D8',
                    400: '#75CCCC',
                    500: '#53BFBF',
                    600: '#3BA0A0',
                    700: '#2C7777',
                    800: '#1D4E4E',
                    900: '#0F2929',
                },
                danger: colors.rose,
                success: colors.green,
                warning: colors.yellow,
            },
            zIndex: {
                '100': '1000',
                '101': '1001',
                '102': '1002',
                '103': '1003',
                '110': '1010',
                '120': '1020'
            },
            spacing: {
                '128': '32rem',
            },
        },
    },

    plugins: [
        require('@tailwindcss/forms'),
        require('@tailwindcss/aspect-ratio'),
        require('@tailwindcss/typography'),
    ],
};

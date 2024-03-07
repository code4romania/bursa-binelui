const defaultTheme = require('tailwindcss/defaultTheme');
const colors = require('tailwindcss/colors');
const plugin = require('tailwindcss/plugin');

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
                DEFAULT: theme('screens.xl'),
            },
        }),
        extend: {
            fontFamily: {
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
            },

            colors: {
                red: {
                    50: '#FEF2F4',
                    100: '#FEE5EA',
                    200: '#FBD0DA',
                    300: '#F8A9BB',
                    400: '#F47898',
                    500: '#EB4C79',
                    600: '#D72762',
                    700: '#B51B52',
                    800: '#98194A',
                    900: '#821945',
                    950: '#480922',
                },
                primary: {
                    50: "#F0F7FF",
                    100: "#A8D2FF",
                    200: "#52A5FF",
                    300: "#0079FA",
                    400: "#0051A5",
                    500: "#00438A",
                    600: "#003670",
                    700: "#002752",
                    800: "#001B38",
                    900: "#000C19",
                    950: "#00070F"
                },
                danger: colors.red,
                success: colors.green,
                warning: colors.yellow,
            },
            zIndex: {
                100: '1000',
                101: '1001',
                102: '1002',
                103: '1003',
                110: '1010',
                120: '1020',
            },
            spacing: {
                128: '32rem',
            },
        },
    },

    plugins: [
        require('@tailwindcss/forms'),
        require('@tailwindcss/aspect-ratio'),
        require('@tailwindcss/typography'),
        plugin(function ({ addVariant }) {
            addVariant('progress-unfilled', ['&::-webkit-progress-bar', '&']);
            addVariant('progress-filled', ['&::-webkit-progress-value', '&::-moz-progress-bar', '&']);
        })
    ],
};

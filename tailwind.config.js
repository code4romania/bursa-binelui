const defaultTheme = require('tailwindcss/defaultTheme');

/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
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
                turqoise: {
                    50:  "#EEF9F9",
                    100: "#B3DFDC",
                    200: "#91DFDA",
                    300: '#C1E8E8',
                    500: '#53BFBF',
                    700: '#41A6AC',
                },
            },
            zIndex: {
                '100': '1000',
            }
        },
    },

    plugins: [
        require('@tailwindcss/forms'),
        require('@tailwindcss/aspect-ratio')
    ],
};

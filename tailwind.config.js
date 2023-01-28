const defaultTheme = require('tailwindcss/defaultTheme');

/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
            },
            colors:{
                'beige':'#f2e7bf',
                'beige-body':'#f2e5b5',
                'dark-beige':'#604d3e',
                'dark-gray':'#323232'
            },
        },
    },

    plugins: [require('@tailwindcss/forms'),require('@tailwindcss/aspect-ratio')],
};

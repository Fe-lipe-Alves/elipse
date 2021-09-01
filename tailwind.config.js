const colors = require('tailwindcss/colors')

module.exports = {
    purge: [
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
    ],
    darkMode: false, // or 'media' or 'class'
    theme: {
        colors: {
            primary: {
                '500': {
                    light: '#85d7ff',
                    DEFAULT: '#1fb6ff',
                    dark: '#009eeb',
                },
                '600': {
                    light: '#509cbd',
                    DEFAULT: '#34647b',
                    dark: '#284b5d',
                }
            },
            brand: {
                light: {
                    DEFAULT: '#fff7f8',
                },
                blue: {
                    DEFAULT: '#3774df',
                },
                red: {
                    DEFAULT: '#d85b66',
                },
            },
            ...colors
        },
        extend: {},
    },
    variants: {
        extend: {},
    },
    plugins: [],
}

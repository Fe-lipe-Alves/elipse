const colors = require('tailwindcss/colors')
const theme = require('tailwindcss/defaultTheme')
const {fontSize} = require("tailwindcss/lib/plugins");

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
        fontFamily: {
            sans: ['Nunito', 'sans-serif'],
        },
        fontSize: {
            'xxs': '.65rem',
            ...theme.fontSize,
        },
        extend: {
            width: {
                '0.5/12': '4.166666%',
                '5.5/12': '45.833332%',
            }
        },
    },
    variants: {
        extend: {},
    },
    plugins: [],
}

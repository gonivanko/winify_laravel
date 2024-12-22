import defaultTheme from 'tailwindcss/defaultTheme';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
            },
            safelist: [
                'bg-backgroundPurple',
                'bg-backgroundRed',
                'bg-backgroundGreen',
                'text-textPurple',
                'text-textRed',
                'text-textGreen',
            ],
            colors: {
                defaultText: '#1E1E1E',
                backgroundPurple: "#EAC2FF",
                textPurple: "#320368",
                backgroundGreen: "#CFF7D3",
                textGreen: "#02542D",
                backgroundRed: "#FDD3D0",
                textRed: "#900B09",
                backgroundYellow: "#FFF1C2",
                textYellow: "#682D03"
                // textBrand: "#5A5A5A",
                // backgroundBrand: "#CDCDCD",
                
            }
        },
    },
    plugins: [],
};

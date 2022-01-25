// const defaultTheme = require('tailwindcss/defaultTheme');

// module.exports = {
//     purge: ['./storage/framework/views/*.php', './resources/views/**/*.blade.php'],

//     theme: {
//         extend: {
//             fontFamily: {
//                 sans: ['Nunito', ...defaultTheme.fontFamily.sans],
//             },
//         },
//     },

//     variants: {
//         opacity: ['responsive', 'hover', 'focus', 'disabled'],
//     },

//     // plugins: [require('@tailwindcss/ui')],
// };


const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
    mode: 'jit',
    content: ['./storage/framework/views/*.php', './resources/views/**/*.blade.php', './Modules/**/resources/views/**/*.blade.php'],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Ubuntu', 'Noto Sans Bengali UI', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [
        require('@tailwindcss/forms'),
        require('@tailwindcss/aspect-ratio'),
        require('@tailwindcss/typography')
    ],
};

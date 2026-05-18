import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';

export default {

    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.jsx",
    ],

    theme: {
        extend: {},
    },

    plugins: [
        forms,
        typography,
    ],
};
const defaultTheme = require('tailwindcss/defaultTheme');

/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ["Figtree", ...defaultTheme.fontFamily.sans],
                patua: ["Patua One"],
            },
            textColor: {
                "peer-request": "#c0c81e",
                "peer-perk": "#079292",
            },
            backgroundColor: {
                "peer-request": "#c0c81e",
                "peer-perk": "#079292",
            },
            borderColor: {
                "peer-request": "#c0c81e",
                "peer-perk": "#079292",
            },
        },
    },

    plugins: [require("@tailwindcss/forms")],
};

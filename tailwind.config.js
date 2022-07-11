/** @type {import('tailwindcss').Config} */
module.exports = {
    mode: "jit",
    content: [
        "./storage/framework/views/*.php",
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
    ],
    theme: {
        extend: {},
        fontFamily: {
            sans: ['"MontserratVariable"', "ui-sans-serif"],
            serif: ["ui-serif", "Georgia"],
            mono: ['"Fira CodeVariable"', "ui-monospace"],
            display: ["MontserratVariable", "ui-sans-serif"],
            body: ["MontserratVariable", "ui-sans-serif"],
        },
        plugins: [],
    },
};

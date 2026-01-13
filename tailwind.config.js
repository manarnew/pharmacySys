/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ['Inter', 'ui-sans-serif', 'system-ui', 'sans-serif'],
            },
            colors: {
                primary: {
                    50: '#eff6ff',  // blue-50
                    100: '#dbeafe', // blue-100
                    200: '#bfdbfe', // blue-200
                    300: '#93c5fd', // blue-300
                    400: '#60a5fa', // blue-400
                    500: '#3b82f6', // blue-500
                    600: '#2563eb', // blue-600
                    700: '#1d4ed8', // blue-700
                    800: '#1e40af', // blue-800
                    900: '#1e3a8a', // blue-900
                    950: '#172554', // blue-950
                },
                // We can also explicitly define slate if we wanted to lock it down, 
                // but default Tailwind slate is perfect.
            }
        },
    },
    plugins: [],
}
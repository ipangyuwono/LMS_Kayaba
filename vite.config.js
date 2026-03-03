import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js', 'resources/js/profile.js', 'resources/js/bootstrap.js', 'resources/js/customers.js', 'resources/js/dashboard.js', 'resources/js/otp.js', 'resources/js/sidebar.js','resources/js/payment.js','resources/js/success.js'],
            refresh: true,
        }),
        tailwindcss(),
    ],
    server: {
        watch: {
            ignored: ['**/storage/framework/views/**'],
        },
    },
});

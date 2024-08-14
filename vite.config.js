import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/home.css',
                'resources/css/dashboard.css',
                'resources/css/transactions.css',
                'resources/js/home.js',
                'resources/js/portal.js',
                'resources/js/dashboard.js',
                'resources/js/transactions.js',
                'resources/js/about.js',
            ],
            refresh: true,
        }),
    ],
});

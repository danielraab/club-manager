import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    server: {
        hmr: {
            host: '127.0.0.1',
        },
    },
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/js/fullCalendar.js',
                'resources/js/trix.umd.min.js',
                'resources/css/trix.css'
            ],
            refresh: true,
        }),
    ],
});

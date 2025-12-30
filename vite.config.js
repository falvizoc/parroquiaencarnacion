import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        tailwindcss(),
    ],
    server: {
        watch: {
            ignored: ['**/storage/framework/views/**'],
        },
    },
    build: {
        // Minificación con esbuild (default de Vite, más rápido)
        minify: 'esbuild',
        // Target moderno para menor bundle size
        target: 'es2020',
        // Source maps solo en desarrollo
        sourcemap: false,
    },
});

import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
    build: {
        // Optimize build for production
        minify: 'esbuild',
        rollupOptions: {
            output: {
                manualChunks: {
                    vendor: ['alpinejs'],
                },
            },
        },
        // Enable source maps for debugging
        sourcemap: false,
        // Optimize chunk size
        chunkSizeWarningLimit: 1000,
    },
    server: {
        // Optimize dev server
        hmr: {
            host: 'localhost',
        },
    },
});

import vue from '@vitejs/plugin-vue';
import autoprefixer from 'autoprefixer';
import laravel from 'laravel-vite-plugin';
import path from 'path';
import tailwindcss from 'tailwindcss';
import { resolve } from 'node:path';
import { defineConfig } from 'vite';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/js/app.ts'],
            ssr: 'resources/js/ssr.ts',
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
    ],
    resolve: {
        alias: {
            '@': path.resolve(__dirname, './resources/js'),
            'ziggy-js': resolve(__dirname, 'vendor/tightenco/ziggy'),
        },
    },
    css: {
        postcss: {
            plugins: [tailwindcss, autoprefixer],
        },
    },
    server: {
        host: '0.0.0.0', // Bind to all interfaces for network access
        port: 5173,
        strictPort: true, // Fail if port 5173 is taken
        cors: {
            origin: 'http://192.168.1.179:8000', // Match Laravel's origin
            credentials: true, // Allow credentials if needed
        },
        hmr: {
            host: '192.168.1.179', // HMR uses your network IP
            port: 5173,
        },
    },
});

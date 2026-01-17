import {
    defineConfig
} from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from "@tailwindcss/vite";

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        tailwindcss(),
    ],
    base: '',
    server: {
        host: '0.0.0.0',
        cors: true,
        hmr: {
            host: 'app.vitakiez.test',
        },
        watch: {
            ignored: ['**/storage/framework/views/**'],
        },
    },
});

import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import autoprefixer from 'autoprefixer'

export default defineConfig({
    server: {
        host: '0.0.0.0',
        hmr: { 
            host: 'localhost', 
        }, 
    },
    plugins: [
        laravel([
            'resources/scss/app.scss',
            '/resources/js/app.js',
            '/resources/js/prism.js',
            '/resources/js/pages/home.js',
            '/resources/js/pages/TMASigns.js',
        ]),
    ],
    css: {
        devSourcemap: true,
        postcss: {
            plugins: [
              autoprefixer()
            ],
          }
    },
});